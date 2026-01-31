#!/bin/bash

# Script لنشر التطبيق على Cloud Laravel مع ملف المفاتيح

echo "🚀 بدء عملية النشر على Cloud Laravel..."

# المتغيرات
REMOTE_USER="your-username"
REMOTE_HOST="your-cloud-laravel-host.com"
REMOTE_PATH="/path/to/your/project"
LOCAL_KEY_FILE="./storage/app/google-auth.json"

# 1. التحقق من وجود ملف المفاتيح محلياً
if [ ! -f "$LOCAL_KEY_FILE" ]; then
    echo "❌ خطأ: ملف المفاتيح غير موجود في $LOCAL_KEY_FILE"
    exit 1
fi

echo "✅ ملف المفاتيح موجود"

# 2. رفع ملف المفاتيح
echo "📤 جاري رفع ملف المفاتيح..."
scp "$LOCAL_KEY_FILE" "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/storage/app/"

if [ $? -eq 0 ]; then
    echo "✅ تم رفع ملف المفاتيح بنجاح"
else
    echo "❌ فشل رفع ملف المفاتيح"
    exit 1
fi

# 3. تعيين الأذونات الصحيحة
echo "🔒 تعيين الأذونات..."
ssh "$REMOTE_USER@$REMOTE_HOST" "cd $REMOTE_PATH && chmod 644 storage/app/google-auth.json"

# 4. مسح الـ Cache
echo "🧹 مسح الـ Cache..."
ssh "$REMOTE_USER@$REMOTE_HOST" "cd $REMOTE_PATH && php artisan config:clear && php artisan cache:clear"

echo "✅ تم النشر بنجاح!"
echo "📝 تأكد من إضافة المتغيرات البيئية:"
echo "  - FILESYSTEM_DISK=gcs"
echo "  - GCS_PROJECT_ID=laravel-gcs-project"
echo "  - GCS_BUCKET=laravel-media-storage-2026"
echo "  - GCS_KEY_FILE=storage/app/google-auth.json"
