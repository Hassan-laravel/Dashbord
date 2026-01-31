# دليل نشر التطبيق على Cloud Laravel

## خطوات رفع الملفات على cloud.laravel

### 1. تحديث ملف المفاتيح Google
تحتاج لرفع ملف `google-auth.json` على السيرفر في المسار:
```
storage/app/google-auth.json
```

**الطريقة الآمنة:**
- عبر SSH:
```bash
# نسخ الملف من جهازك إلى السيرفر
scp storage/app/google-auth.json user@cloud-laravel.com:/path/to/project/storage/app/
```

- أو عبر لوحة التحكم (Panel Control) إذا توفرت ميزة File Manager

### 2. إضافة متغيرات البيئة على cloud.laravel

أضف هذه المتغيرات في `.env` على السيرفر أو عبر لوحة التحكم:

```env
FILESYSTEM_DISK=gcs
GCS_PROJECT_ID=laravel-gcs-project
GCS_BUCKET=laravel-media-storage-2026
GCS_KEY_FILE=storage/app/google-auth.json
```

### 3. التحقق من الأذونات
```bash
# التأكد من أن المجلد storage له أذونات صحيحة
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### 4. مسح الـ Cache
```bash
php artisan config:clear
php artisan cache:clear
```

### 5. اختبار الاتصال
استدعِ الرابط:
```
GET https://your-domain.com/api/test-gcs-connection
```

يجب أن تحصل على استجابة ناجحة.

## استكشاف الأخطاء

### خطأ: "Unable to list contents for '/', shallow listing"
**السبب:** ملف المفاتيح غير موجود أو المسار خاطئ

**الحل:**
1. تحقق من وجود `storage/app/google-auth.json`
2. تأكد من صلاحيات الملف: `chmod 644 storage/app/google-auth.json`

### خطأ: "File not found"
**السبب:** المسار في `GCS_KEY_FILE` غير صحيح

**الحل:**
- تأكد أن `GCS_KEY_FILE` مشار إليه كـ `storage/app/google-auth.json` وليس مسار مطلق

### خطأ: "403 Forbidden"
**السبب:** بيانات الاعتماد (credentials) غير صحيحة

**الحل:**
- تحقق من صحة محتوى `google-auth.json`
- تأكد أن service account لديه صلاحيات على Bucket

## ملاحظات أمان مهمة

⚠️ **لا تضع `google-auth.json` في Git!**

تأكد من وجود السطر في `.gitignore`:
```
storage/app/google-auth.json
```

## محتوى ملف .env على السيرفر

يجب أن يحتوي على:
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=[your-app-key]
APP_URL=https://your-domain.com

DB_HOST=[your-db-host]
DB_DATABASE=[your-db-name]
DB_USERNAME=[your-db-user]
DB_PASSWORD=[your-db-password]

FILESYSTEM_DISK=gcs
GCS_PROJECT_ID=laravel-gcs-project
GCS_BUCKET=laravel-media-storage-2026
GCS_KEY_FILE=storage/app/google-auth.json
```
