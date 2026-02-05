# 📰 News & Articles Admin Dashboard (with JSON API)

A professional Laravel-based management system for news, articles, and static pages. This project serves as a content hub that manages media via **Google Cloud Storage** and exports all database content as **JSON API endpoints**.



## 🌟 Key Features
* **Article Management:** Full CRUD operations for news and blog posts.
* **Categorization:** Dynamic category system for organizing content.
* **JSON API Export:** All articles, categories, and pages are accessible via JSON links.
* **Cloud Integration:** Native integration with **Google Cloud Storage (GCS)** for image hosting.
* **Pre-configured Data:** Includes Seeders for immediate testing.

---

## 🛠 Prerequisites
Before installation, ensure you have:
* **PHP:** >= 8.1
* **Composer**
* **Node.js & NPM**
* **Database:** MySQL / PostgreSQL
* **Google Cloud Account:** A service account JSON key and an active bucket.

---

## 📥 Installation Guide

### 1. Clone the Repository
```bash

git clone (https://github.com/Hassan-laravel/Dashbord.git)
cd your-repo-name
2. Install PHP & JS Dependencies
# Install Laravel packages
composer install

# Install and compile frontend assets
npm install
npm run build

3. Environment Setup
Copy the example environment file and generate your application key:
cp .env.example .env
php artisan key:generate

4. Database & Seeding
Configure your DB_* variables in the .env file, then run the migrations along with the seeders to populate categories and sample articles:
php artisan migrate --seed


5. Google Cloud Storage Configuration
Add your credentials to the .env file to handle media:

Place your JSON key file in storage/app/google-cloud-key.json.

Update the following fields:

مقتطف الرمز
FILESYSTEM_DISK=gcs
GCS_PROJECT_ID=your-gcp-project-id
GCS_BUCKET=your-bucket-name
GCS_KEY_FILE=storage/app/google-cloud-key.json

🚀 Running the Project
Start the local development server:
php artisan serve
Access the dashboard at http://127.0.0.1:8000.

Pro Tip: Check DatabaseSeeder.php to find the default admin login credentials created during the seeding process.
