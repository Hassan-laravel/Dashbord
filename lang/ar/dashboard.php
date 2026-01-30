<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard Translations - Arabic
    |--------------------------------------------------------------------------
    */

    // 1. نصوص عامة تستخدم في كل مكان
    'general' => [
        'dashboard' => 'لوحة التحكم',
        'home' => 'الرئيسية',
        'actions' => 'العمليات',
        'status' => 'الحالة',
        'created_at' => 'تاريخ الإضافة',
        'save' => 'حفظ',
        'update' => 'تحديث',
        'delete' => 'حذف',
        'edit' => 'تعديل',
        'cancel' => 'إلغاء',
        'close' => 'إغلاق',
        'search' => 'بحث',
        'reset' => 'إعادة تعيين',
        'yes' => 'نعم',
        'no' => 'لا',
        'active' => 'مفعل',
        'inactive' => 'غير مفعل',
        'image' => 'الصورة',
        'confirm_delete_msg' => 'هل أنت متأكد من الحذف؟ لا يمكن التراجع عن هذا الإجراء.',
        'entry_language' => 'أنت تقوم بالإدخال للغة:',
        'auto_generated' => 'يتم التوليد تلقائياً',
        'no_data' => 'لا يوجد بيانات لعرضها',
        'search' => 'بحث',
        'search_placeholder' => 'بحث بعنوان المقال...',
        'reset' => 'إعادة تعيين',
        'loading' => 'جاري التحديث...',
        'image' => 'الصورة',
        'actions' => 'العمليات',
        'created_at' => 'تاريخ النشر',
        'status' => 'الحالة',
        'unknown' => 'غير معروف',
        'no_image' => 'بلا صورة',
        'no_results' => 'لا توجد نتائج تطابق بحثك',
        'all_statuses' => 'كل الحالات',
    ],

    // 2. القائمة الجانبية
    'nav' => [
        'users' => 'إدارة المستخدمين',
        'categories' => 'التصنيفات',
        'posts' => 'المقالات',
        'settings' => 'الإعدادات',
        'pages' => 'الصفحات',
        'logout' => 'تسجيل الخروج',
    ],

    // 3. قسم المستخدمين
    'users' => [
        'title' => 'إدارة المستخدمين',
        'list' => 'قائمة المستخدمين',
        'add_user' => 'إضافة مستخدم جديد',
        'edit_user' => 'تعديل بيانات المستخدم',
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'password_confirm' => 'تأكيد كلمة المرور',
        'password_placeholder' => 'اتركه فارغاً إذا لم ترد التغيير',
        'role' => 'الصلاحية / الدور',
        'select_role' => 'اختر الصلاحية',
        'modal_title' => 'بيانات المستخدم',
    ],

    // 4. قسم التصنيفات
    'categories' => [
        'title' => 'إدارة التصنيفات',
        'list' => 'قائمة التصنيفات',
        'add_new' => 'إضافة تصنيف',
        'edit_category' => 'تعديل التصنيف',
        'name' => 'اسم التصنيف',
        'slug' => 'الرابط (Slug)',
        'meta_title' => 'عنوان SEO',
        'meta_description' => 'وصف SEO / كلمات دلالية',
        'active' => 'مفعل',
        'inactive' => 'غير مفعل',
        'all' => 'كل التصنيفات',
    ],

    // 5. قسم المقالات
    'posts' => [
        'title' => 'إدارة المقالات',
        'list' => 'قائمة المقالات',
        'add_new' => 'إضافة مقال جديد',
        'edit_post' => 'تعديل المقال',

        // الحقول
        'article_title' => 'عنوان المقال',
        'article_title_placeholder' => 'أدخل عنوان المقال هنا...',
        'content' => 'المحتوى',
        'content_placeholder' => 'اكتب محتوى المقال هنا...',
        'youtube_link' => 'رابط يوتيوب (اختياري)',

        // الأقسام الجانبية
        'seo_section' => 'تحسين محركات البحث (SEO)',
        'publish_section' => 'نشر',
        'categories_section' => 'التصنيفات',
        'featured_image' => 'الصورة البارزة',
        'gallery' => 'معرض الصور',

        // خيارات
        'status' => 'الحالة',
        'status_published' => 'منشور',
        'status_draft' => 'مسودة',
        'no_categories' => 'لا يوجد تصنيفات.',
        'add_category_link' => 'أضف تصنيفاً',
        'gallery_help' => 'يمكنك اختيار أكثر من صورة',
        'select_multiple' => 'اختر صور متعددة',

        // أزرار
        'save_btn' => 'حفظ المقال',
        'update_btn' => 'تحديث المقال',
        'title' => 'إدارة المقالات',
        'list' => 'قائمة المقالات',
        'add_new' => 'إضافة مقال جديد',
        'article_title' => 'عنوان المقال',
        'author' => 'الكاتب',
        'status_published' => 'منشور',
        'status_draft' => 'مسودة',

    ],

    // 6. رسائل النظام (Flash Messages)
    'messages' => [
        'success' => 'عملية ناجحة',
        'error' => 'حدث خطأ',
        // المستخدمين
        'user_created' => 'تم إنشاء المستخدم وتعيين الصلاحيات بنجاح',
        'user_updated' => 'تم تحديث بيانات المستخدم بنجاح',
        'user_deleted' => 'تم حذف المستخدم بنجاح',
        'cannot_delete_self' => 'عذراً، لا يمكنك حذف حسابك الشخصي!',
        // التصنيفات
        'category_created' => 'تم إنشاء التصنيف بنجاح',
        'category_updated' => 'تم تحديث التصنيف بنجاح',
        'category_deleted' => 'تم حذف التصنيف بنجاح',
        // المقالات
        'post_created' => 'تم إضافة المقال بنجاح',
        'post_updated' => 'تم تحديث المقال بنجاح',
        'post_deleted' => 'تم حذف المقال بنجاح',
    ],'settings' => [
        'title' => 'إعدادات الموقع',
        'site_email' => 'البريد الإلكتروني',
        'site_logo' => 'شعار الموقع (Logo)',
        'maintenance_mode' => 'وضع الصيانة',
        'site_name' => 'اسم الموقع',
        'site_description' => 'وصف الموقع',
        'copyright' => 'حقوق النشر (Copyright)',
        'save_settings' => 'حفظ الإعدادات',
        'on' => 'مفعل',
        'off' => 'معطل',
    ],'pages' => [
        'title' => 'إدارة الصفحات',
        'list' => 'قائمة الصفحات',
        'add_new' => 'إضافة صفحة جديدة',
        'edit_page' => 'تعديل الصفحة',
        'page_title' => 'عنوان الصفحة',
        'content' => 'محتوى الصفحة',
        'featured_image' => 'صورة الصفحة',
    ],
];
