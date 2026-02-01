
بعد أن تقوم بتعديل ملف الـ README في محرّر الكود الخاص بك (مثل VS Code)، اتبع "الدورة الاحترافية" التي تعلمناها:

1.  **تجهيز الملف:**
    ```bash
    git add README.md
    ```
2.  **توثيق التعديل:**
    ```bash
    git commit -m "Update README with project details and installation guide"
    ```
3.  **الرفع:**
    ```bash
    git push
    ```

### نصيحة إضافية للمستقبل:
بما أنك تستخدم **Laravel 12**، حاول دائماً في مشاريعك القادمة إضافة "صور" (Screenshots) للمشروع في ملف الـ README، فهذا يزيد من فرصة إعجاب أصحاب العمل بعملك بنسبة كبيرة جداً.

**هل تريدني أن أشرح لك كيف تضيف صوراً للمشروع وتظهرها داخل ملف الـ README بشكل أنيق؟**


# 📱 Mobile App Backend – Laravel 12

Backend احترافي مبني باستخدام **Laravel 12** لتطبيقات الجوال  
(Android / iOS) عبر REST API.

---

## 🚀 المميزات

- 🔐 تسجيل دخول وتوثيق باستخدام Laravel Sanctum
- 👤 إدارة المستخدمين
- 📡 RESTful API
- 🗄️ MySQL / PostgreSQL
- 🔔 الإشعارات
- ⚡ أداء عالي وقابلية توسّع

---

## 🛠️ التقنيات المستخدمة

- Laravel 12
- PHP 8.3+
- MySQL
- Laravel Sanctum
- Composer

---

## 📦 المتطلبات

تأكد من توفر التالي على جهازك:

- PHP >= 8.3
- Composer
- MySQL
- Node.js (اختياري)

---

## ⚙️ طريقة التثبيت

### 1️⃣ استنساخ المشروع
```bash
git clone https://github.com/your-username/project-name.git
cd project-name
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve


---

### 💡 نصيحة
لو تحب:
- README بالعربي فقط
- README لمشروع Flutter + Laravel
- README بسيط أو احترافي جدًا
- إضافة Badges (GitHub / CI / PHP Version)

قلّي وش النوع، وأجهزه لك فورًا 😎📘
git remote -v
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin [رابط_مستودعك]
git push -u origin main
git pull origin main
git remote set-url origin [الرابط_الجديد]
aNscuMuNNIiVaSzaVRZqhgQtHsVfWOTW
railway
aNscuMuNNIiVaSzaVRZqhgQtHsVfWOTW


php artisan migrate --force && php artisan serve --host 0.0.0.0 --port $PORT
Cursor وClaude Code

rm .git/index.lock
git status
git add .
git commit -m "Setup Cloudinary for image hosting"
git push origin main --force
git rebase --continue
git add -f storage/app/google-auth.json
git pull origin main --rebase
git rm --cached storage/app/google-auth.json
git commit -m "Remove secret key and ignore it"
git push
GitHub secrets
ipconfig /flushdns
[Convert]::ToBase64String([Text.Encoding]::UTF8.GetBytes((Get-Content -Raw .\storage\app\google-auth.json)))
php artisan tinker
https://tableplus.com/ 

composer require cloudinary-labs/cloudinary-laravel
'cloudinary' => [
        'driver' => 'cloudinary',
    ],
// بدلاً من التخزين المحلي، سيقوم لارافل بالرفع تلقائياً لـ Cloudinary
$path = $request->file('image')->store('posts', 'cloudinary');

// للحصول على الرابط المباشر للصورة لعرضه في الموقع
$url = Storage::disk('cloudinary')->url($path);

CLOUDINARY_CLOUD_NAME=drtowksk4
CLOUDINARY_API_KEY=931454319689594
CLOUDINARY_API_SECRET=ulukiUH5d4WqdZt21v-DIdfyu_4
FILESYSTEM_DISK=cloudinary
