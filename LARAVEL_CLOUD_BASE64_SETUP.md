# 🚀 نشر Google Cloud Storage على Laravel Cloud باستخدام Base64

## ✅ الخطوة 1: توليد سلسلة Base64 محلياً

> **لماذا Base64؟** لأنها تحول محتوى JSON إلى سطر واحد بدون مشاكل أسطر جديدة أو اقتباسات، مما يجعلها آمنة للصق في واجهات ضبط المتغيرات.

### Windows PowerShell

افتح PowerShell وتأكد من أنك في مجلد المشروع، ثم نفّذ:

```powershell
[Convert]::ToBase64String([Text.Encoding]::UTF8.GetBytes((Get-Content -Raw .\storage\app\google-auth.json)))
```

**النتيجة:** ستحصل على سلسلة طويلة مثل:
```
eyJ0eXBlIjogInNlcnZpY2VfYWNjb3VudCIsICJwcm9qZWN0X2lkIjogImxhcmF2ZWwtZ2NzLXByb2plY3QiLCAicHJpdmF0ZV9rZXlfaWQiOiAi...
```

**انسخ هذه السلسلة بالكامل.**

### Linux / macOS

```bash
base64 -w 0 storage/app/google-auth.json
```

---

## ✅ الخطوة 2: إضافة متغيرات البيئة في Laravel Cloud

### الطريقة الأولى: عبر لوحة Laravel Cloud Dashboard

1. افتح **Laravel Cloud Dashboard**
2. انتقل إلى مشروعك
3. اذهب إلى **Environment Variables** (أو **Settings** > **Environment**)
4. أضف أو عدّل المتغيرات التالية:

| المتغير | القيمة |
|--------|--------|
| `FILESYSTEM_DISK` | `gcs` |
| `GCS_PROJECT_ID` | `laravel-gcs-project` |
| `GCS_BUCKET` | `laravel-media-storage-2026` |
| `GCS_KEY_FILE` | (السلسلة Base64 التي نسختها أعلاه) |

### مثال قيمة `GCS_KEY_FILE`:
```
eyJ0eXBlIjogInNlcnZpY2VfYWNjb3VudCIsICJwcm9qZWN0X2lkIjogImxhcmF2ZWwtZ2NzLXByb2plY3QiLCAicHJpdmF0ZV9rZXlfaWQiOiAi...
```

### الطريقة الثانية: عبر GitHub Secrets (اختيارية)

إذا كان مشروعك مرتبطاً بـ GitHub workflow ويدعم secrets:

1. افتح GitHub Repository > **Settings** > **Secrets and variables** > **Actions**
2. أضف secret جديد:
   - Name: `GCS_KEY_FILE_BASE64`
   - Value: (السلسلة Base64)
3. استرجع القيمة في `.env` أو في Laravel Cloud deployment config

---

## ✅ الخطوة 3: إعادة نشر (Redeploy)

بعد تحديث متغيرات البيئة:

1. في لوحة Laravel Cloud، اضغط على **Redeploy** أو **Deploy**
2. انتظر حتى انتهاء النشر (عادةً 2-5 دقائق)

---

## ✅ الخطوة 4: اختبار الاتصال

استدعِ رابط الاختبار:

```
GET https://your-domain.com/api/test-gcs-connection
```

### ✅ استجابة ناجحة:
```json
{
  "status": "success",
  "message": "تم الاتصال بـ Google Cloud Storage بنجاح",
  "config": {
    "project_id": "laravel-gcs-project",
    "bucket": "laravel-media-storage-2026",
    "key_file_source": "env_base64",
    "key_file_path": null,
    "files_count": 0,
    "service_account": "laravel-access@laravel-gcs-project.iam.gserviceaccount.com"
  }
}
```

### ❌ استجابة فاشلة مع معلومات تشخيصية:
```json
{
  "status": "error",
  "message": "ملف المفاتيح غير موجود أو غير صالح. تأكد من قيمة GCS_KEY_FILE...",
  "key_file_value_preview": "...",
  "key_file_source_attempted": null,
  "full_path": null
}
```

إذا حصلت على استجابة فاشلة، تحقق من:
- ✅ هل السلسلة Base64 كاملة (نسختها بالكامل بدون حذف أي حرف)؟
- ✅ هل المتغيرات `GCS_PROJECT_ID` و `GCS_BUCKET` صحيحة؟
- ✅ هل أعدت نشر (redeploy) التطبيق بعد تحديث المتغيرات؟

---

## ✅ الخطوة 5: رفع واختبار الصور

بعد التأكد من الاتصال:

### 1. رفع صورة اختبار:
```
POST https://your-domain.com/api/test-gcs-upload
```

**Body:** form-data
- Field name: `image`
- Value: (اختر صورة من جهازك)

### 2. الاستجابة المتوقعة:
```json
{
  "status": "success",
  "message": "تم رفع الصورة بنجاح",
  "path": "uploads/abc123.jpg",
  "url": "https://storage.googleapis.com/laravel-media-storage-2026/uploads/abc123.jpg",
  "filename": "test.jpg"
}
```

### 3. تحقق من الصور في الـ Dashboard:
- ادخل إلى صفحة إنشاء/تعديل مقالة أو صفحة
- ارفع صورة جديدة
- يجب أن ترى الصورة معروضة وتأتي من Google Cloud Storage

---

## 🔐 نصائح أمان

⚠️ **لا تضع `google-auth.json` في Git**

```gitignore
storage/app/google-auth.json
```

✅ **استخدم Base64 بدلاً من النص الخام** لتجنب مشاكل الأسطر والاقتباسات.

✅ **احتفظ بنسخة احتياطية** من `google-auth.json` في مكان آمن.

---

## 📞 استكشاف الأخطاء

| الخطأ | السبب | الحل |
|------|------|------|
| `"status": "error", "message": "ملف المفاتيح غير موجود"` | قيمة `GCS_KEY_FILE` غير صحيحة | تحقق من سلسلة Base64 وأعد نسخها بدقة |
| `"403 Forbidden"` عند رفع صورة | صلاحيات GCS ناقصة | تحقق من Google Cloud Console، تأكد أن Service Account لديه `Storage Object Creator` |
| الصور لا تظهر في Dashboard | متغيرات البيئة لم تحمّل بعد | أعد نشر (redeploy) التطبيق مرة أخرى |
| `JSON غير صحيح` | Base64 مقطوع أو ناقص | انسخ السلسلة كاملة بدون ترك أي حرف |

---

## 📝 ملخص الملفات المعدلة

| الملف | التعديل |
|------|---------|
| `config/filesystems.php` | دعم Base64 وraw JSON في `key_file` |
| `app/Http/Controllers/GcsTestController.php` | تشخيص أفضل للخطأ `testConnection()` |
| `.env` و `.gitignore` | متغيرات البيئة وتجاهل ملف المفاتيح |
| `CLOUD_DEPLOYMENT.md` | توثيق عام للنشر على الخوادم |

---

**تم!** 🎉 الآن يجب أن يعمل كل شيء بدون مشاكل على Laravel Cloud.
