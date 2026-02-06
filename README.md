# News-CMS

A professional, multilingual News Management System (CMS) built with **Laravel 12**. This project features a robust dashboard for managing categories, articles, and settings with full multi-language support (Arabic & English).

---

## 🚀 Features

- **Multilingual Support**: Fully translatable categories, posts, pages, and settings (using `astrotomic/laravel-translatable`).
- **Cloud Storage**: Integrated with **Google Cloud Storage (GCS)** for media hosting (using `spatie/laravel-google-cloud-storage`).
- **Role-Based Access Control (RBAC)**: Fine-grained permissions for Admins and Editors (using `spatie/laravel-permission`).
- **Modern UI**: Styled with **Tailwind CSS v4** and bundled with **Vite**.
- **API First**: Designed to output **JSON responses** for easy integration with frontend frameworks or mobile apps.
- **Contact Management**: Integrated contact form handling with rate limiting.

---

## 🛠️ Technology Stack

| Component       | Technology                                 |
| :-------------- | :----------------------------------------- |
| **Framework**   | [Laravel 12](https://laravel.com)          |
| **PHP Version** | ^8.2                                       |
| **Styling**     | [Tailwind CSS v4](https://tailwindcss.com) |
| **Build Tool**  | [Vite 7](https://vitejs.dev)               |
| **Database**    | MySQL / SQLite (Standard Laravel)          |

---

## 📦 Installed Libraries

### PHP (Composer)

- `astrotomic/laravel-translatable`: For multilingual content management.
- `spatie/laravel-google-cloud-storage`: For GCS disk integration.
- `spatie/laravel-permission`: For roles and permissions.
- `laravel/sanctum`: For API authentication.
- `laravel/tinker`: Interactive console.

---

## 📡 API Documentation

The project provides a clean JSON API for external consumption. Localized routes use the `SetApiLocale` middleware to deliver content in the requested language.

### Base URL

`http://your-domain.com/api`

### Endpoints

| Method   | Endpoint               | Description                                     |
| :------- | :--------------------- | :---------------------------------------------- |
| **GET**  | `/settings`            | Get global site settings (CMS configurations).  |
| **GET**  | `/posts`               | List all published posts (supports pagination). |
| **GET**  | `/posts/{slug}`        | Get details of a single post by slug.           |
| **GET**  | `/categories`          | List all available categories.                  |
| **GET**  | `/categories/{slug}`   | Get posts belonging to a specific category.     |
| **GET**  | `/pages`               | List all static pages.                          |
| **GET**  | `/pages/{slug}`        | Get content of a specific static page.          |
| **POST** | `/contact/send`        | Submit contact form (Throttled: 5 req/min).     |
| **GET**  | `/test-gcs-connection` | Verify Google Cloud Storage connectivity.       |
| **POST** | `/test-gcs-upload`     | Test file upload to GCS.                        |

> [!TIP]
> **Localization**: The API automatically detects the language preferred by the client. Ensure your requests include the appropriate locale headers if configured in `SetApiLocale` middleware.

---

## 📂 Database Structure

The project includes several key tables to manage the CMS functionality:

- **`users`**: Managed roles and credentials.
- **`categories`** / **`category_translations`**: Multilingual categories.
- **`posts`** / **`post_translations`**: Articles with status management.
- **`post_images`**: Relation for article media.
- **`settings`** / **`setting_translations`**: Global CMS configurations.
- **`pages`** / **`page_translations`**: Custom static pages.
- **`contacts`**: Form submissions storage.

---

## 🔧 Installation & Setup

### 1. Prerequisites

- PHP ^8.2, Composer, Node.js & NPM, MySQL or SQLite.

### 2. Clone and Install

```bash
composer install
npm install
```

### 3. Configuration

```bash
cp .env.example .env
php artisan key:generate
```

> [!IMPORTANT]
> Update your `.env` file with your database credentials and GCS keys:
>
> - `FILESYSTEM_DISK=gcs`
> - `GOOGLE_CLOUD_PROJECT_ID=...`
> - `GOOGLE_CLOUD_KEY_FILE=...`

### 4. Database Setup

```bash
php artisan migrate --seed
```

### 5. Start Development Server

```bash
npm run dev
```

---

## 🛡️ Default Credentials

- **Admin**: `admin@app.com` (Password: `password`)
- **Editor**: `editor@app.com` (Password: `password`)

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).
