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

### 4️⃣ رفع ملف المفاتيح

**الطريقة الأولى: عبر SCP (من جهازك)**
```bash
scp storage/app/google-auth.json user@cloud-laravel.com:/path/to/project/storage/app/
```

**الطريقة الثانية: عبر File Manager في لوحة التحكم**
- اذهب إلى File Manager
- انتقل إلى `storage/app/`
- رفع الملف `google-auth.json`

### 5️⃣ تحديث `.env` على السيرفر
أضف أو عدّل هذه الأسطر:
```env
FILESYSTEM_DISK=gcs
GCS_PROJECT_ID=laravel-gcs-project
GCS_BUCKET=laravel-media-storage-2026
GCS_KEY_FILE=storage/app/google-auth.json
```

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
