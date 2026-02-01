# 📋 خطوات نشر التطبيق على Cloud Laravel مع Google Cloud Storage

## 🔧 المتطلبات
- ملف `google-auth.json` من Google Cloud Console
- وصول SSH إلى خادم Cloud Laravel
- PHP 8.0+

## 📝 خطوات النشر

### 1️⃣ تحضير الملفات محلياً
تأكد من وجود ملف `storage/app/google-auth.json`

### 2️⃣ رفع الكود على السيرفر
```bash
git push origin main
```

### 3️⃣ الاتصال بـ SSH على السيرفر
```bash
ssh user@cloud-laravel.com
cd /path/to/your/project
```

> ملاحظة خاصة ببيئة **Laravel Cloud**: إذا كان مشروعك مستضافًا على Laravel Cloud فغالبًا لا تتوفر لديك صلاحية SSH أو ملف مدير (File Manager) لأن الملفات تُزامن مباشرةً من مستودع GitHub. في هذه الحالة يجب توفير بيانات اعتماد GCS عبر متغيرات البيئة في لوحة تحكم Laravel Cloud (أو عبر GitHub repository secrets المربوطة)، وليس برفع ملف `google-auth.json` يدوياً إلى السيرفر.


### 4️⃣ رفع ملف المفاتيح

**الطريقة الأولى (تقليدية): عبر SCP (من جهازك)**
```bash
scp storage/app/google-auth.json user@cloud-laravel.com:/path/to/project/storage/app/
```

**ملاحظة Laravel Cloud (لا يمكن رفع الملف يدوياً):**
- إذا استضافت تطبيقك على Laravel Cloud، لا ترفع الملف يدويًا، بل ضع بيانات الاعتماد إما كـ raw JSON أو كـ Base64 في متغير البيئة `GCS_KEY_FILE` عبر لوحة Laravel Cloud أو GitHub secrets.

### طرق تقديم بيانات الاعتماد (قيمة `GCS_KEY_FILE`)
1. مسار نسبي داخل المشروع (مثال: `storage/app/google-auth.json`) — يعمل فقط إذا رفعت الملف إلى المستودع.
2. النص الكامل لـ JSON (الصقه مباشرة في قيمة المتغير) — قد يواجهك مشكلات مع الأسطر في بعض لوحات التحكم.
3. أفضل خيار: **Base64-encoded JSON** (سطر واحد) لتجنب مشاكل الأسطر والاقتباسات.

مثال: قيمة `GCS_KEY_FILE` ستكون مثل:
```env
GCS_KEY_FILE=eyJ0eXBlIjogInNlcnZpY2VfYWNjb3VudCIsICJwcm9qZWN0X2lkIjogIm15LXByb2plY3QiLCAuLi59
```

تابع القسم أدناه لمعرفة كيفية توليد سلسلة Base64 محلياً والنشر على Laravel Cloud.

### 5️⃣ تحديث المتغيرات البيئية (`.env`) أو لوحة Laravel Cloud

إذا تعمل على خادم تقليدي مع إمكانية تعديل الملفات على السيرفر، ضع هذه القيم في ملف `.env`:

```env
FILESYSTEM_DISK=gcs
GCS_PROJECT_ID=laravel-gcs-project
GCS_BUCKET=laravel-media-storage-2026
GCS_KEY_FILE=storage/app/google-auth.json
```

إذا استضافت التطبيق على **Laravel Cloud** (بدون SSH) فضع المتغيرات نفسها عبر لوحة التحكم (Environment Variables) أو عبر GitHub secrets المربوطة. بالنسبة لقيمة `GCS_KEY_FILE` يمكنك استخدام أي من الصيغ الثلاث:

- مسار نسبي داخل المشروع: `storage/app/google-auth.json` (يعمل فقط إن رفعت الملف إلى المستودع).
- النص الكامل لملف JSON (الصقه مباشرة).
- سلسلة Base64 للـ JSON (موصى به لتجنب مشاكل الأسطر والاقتباسات).

#### توليد Base64 محلياً
Linux / macOS:
```bash
base64 -w 0 storage/app/google-auth.json
```

Windows PowerShell (سطر واحد):
```powershell
[Convert]::ToBase64String([Text.Encoding]::UTF8.GetBytes((Get-Content -Raw .\storage\app\google-auth.json)))
```

انسخ الناتج وألصقه كقيمة للمتغير `GCS_KEY_FILE` في لوحة Laravel Cloud. مثال:

```env
GCS_KEY_FILE=BASE64_ENCODED_STRING_HERE
```

بعد تحديث متغيرات البيئة في لوحة التحكم، **أعد نشر (redeploy)** التطبيق عبر واجهة Laravel Cloud حتى تُحمَل المتغيرات الجديدة.

### 6️⃣ تعيين الأذونات
```bash
chmod 644 storage/app/google-auth.json
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### 7️⃣ مسح الـ Cache
```bash
php artisan config:clear
php artisan cache:clear
```

### 8️⃣ اختبار الاتصال
استدعِ:
```
GET https://your-domain.com/api/test-gcs-connection
```

يجب أن تحصل على استجابة مثل:
```json
{
  "status": "success",
  "message": "تم الاتصال بـ Google Cloud Storage بنجاح",
  "config": {
    "project_id": "laravel-gcs-project",
    "bucket": "laravel-media-storage-2026",
    "key_file": "google-auth.json",
    "key_file_path": "/path/to/project/storage/app/google-auth.json",
    "files_count": 0,
    "service_account": "laravel-access@laravel-gcs-project.iam.gserviceaccount.com"
  }
}
```

## ⚠️ استكشاف الأخطاء

### ❌ "File not found"
**الحل:**
```bash
# تحقق من وجود الملف
ls -la storage/app/google-auth.json

# إذا لم يكن موجود، رفعه مرة أخرى
```

### ❌ "Permission denied"
**الحل:**
```bash
chmod 644 storage/app/google-auth.json
```

### ❌ "Invalid JSON"
**الحل:**
- تأكد من أن محتوى `google-auth.json` صحيح
- تأكد من عدم وجود أحرف إضافية

### ❌ "403 Forbidden"
**الحل:**
- تحقق من صلاحيات service account في Google Cloud Console
- تأكد أن `Storage Object Viewer` و `Storage Object Creator` معطاة

## 🔐 أمان مهم

⚠️ **لا تضع `google-auth.json` في Git!**

تأكد من وجود هذا السطر في `.gitignore`:
```
storage/app/google-auth.json
```

إذا كان موجود بالخطأ في Git:
```bash
git rm --cached storage/app/google-auth.json
git commit -m "Remove google-auth.json from git"
git push origin main
```

## 📚 ملفات مهمة

- `.env` - المتغيرات البيئية
- `config/filesystems.php` - إعدادات التخزين
- `app/Traits/HandlesGcsImage.php` - التعامل مع الصور
- `app/Http/Controllers/GcsTestController.php` - اختبار الاتصال

## ✅ اختبار الميزات

بعد النشر، جرب:

### 1. رفع صورة
```
POST /api/test-gcs-upload
Body: form-data with 'image' field
```

### 2. عرض الصور
- الصفحات: صور الـ dashboard تظهر من GCS
- المقالات: صور المقالات تظهر من GCS
- الإعدادات: شعار الموقع يظهر من GCS

### 3. API
- جميع روابط الصور في API تعود من GCS

---

**نصيحة:** احتفظ بنسخة احتياطية من `google-auth.json` في مكان آمن! 🔒
