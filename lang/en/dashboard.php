<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard Translations - English
    |--------------------------------------------------------------------------
    */

    // 1. General Texts
    'general' => [
        'dashboard' => 'Dashboard',
        'home' => 'Home',
        'actions' => 'Actions',
        'status' => 'Status',
        'created_at' => 'Created At',
        'save' => 'Save',
        'update' => 'Update',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'cancel' => 'Cancel',
        'close' => 'Close',
        'search' => 'Search',
        'reset' => 'Reset',
        'yes' => 'Yes',
        'no' => 'No',
        'active' => 'Active',
        'inactive' => 'Inactive',
        'image' => 'Image',
        'confirm_delete_msg' => 'Are you sure you want to delete? This action cannot be undone.',
        'entry_language' => 'You are entering data for language:',
        'auto_generated' => 'Auto-generated',
        'no_data' => 'No data available',

        'search' => 'Search',
        'search_placeholder' => 'Search by post title...',
        'reset' => 'Reset',
        'loading' => 'Loading...',
        'image' => 'Image',
        'actions' => 'Actions',
        'created_at' => 'Created At',
        'status' => 'Status',
        'unknown' => 'Unknown',
        'no_image' => 'No Image',
        'no_results' => 'No results match your search',
        'all_statuses' => 'All Statuses',
        'welcome_msg' => 'Welcome <strong>:name</strong> to the dashboard.',
    ],

    // 2. Navigation
    'nav' => [
        'users' => 'Users Management',
        'categories' => 'Categories',
        'posts' => 'Posts',
        'settings' => 'Settings',
        'pages' => 'Pages',
        'logout' => 'Logout',
    ],

    // 3. Users Section
    'users' => [
        'title' => 'Users Management',
        'list' => 'Users List',
        'add_user' => 'Add New User',
        'edit_user' => 'Edit User Details',
        'name' => 'Name',
        'email' => 'Email Address',
        'password' => 'Password',
        'password_confirm' => 'Confirm Password',
        'password_placeholder' => 'Leave blank to keep current password',
        'role' => 'Role',
        'select_role' => 'Select Role',
        'modal_title' => 'User Details',
    ],

    // 4. Categories Section
    'categories' => [
        'title' => 'Categories Management',
        'list' => 'Categories List',
        'add_new' => 'Add New Category',
        'edit_category' => 'Edit Category',
        'name' => 'Category Name',
        'slug' => 'Slug',
        'meta_title' => 'SEO Title',
        'meta_description' => 'SEO Description / Keywords',
        'active' => 'Active',
        'inactive' => 'Inactive',
        'all' => 'All Categories',
    ],

    // 5. Posts Section
    'posts' => [
        'title' => 'Posts Management',
        'list' => 'Posts List',
        'add_new' => 'Add New Post',
        'edit_post' => 'Edit Post',

        // Fields
        'article_title' => 'Post Title',
        'article_title_placeholder' => 'Enter post title here...',
        'content' => 'Content',
        'content_placeholder' => 'Write post content here...',
        'youtube_link' => 'YouTube Link (Optional)',

        // Side Sections
        'seo_section' => 'Search Engine Optimization (SEO)',
        'publish_section' => 'Publish',
        'categories_section' => 'Categories',
        'featured_image' => 'Featured Image',
        'gallery' => 'Gallery',

        // Options
        'status' => 'Status',
        'status_published' => 'Published',
        'status_draft' => 'Draft',
        'no_categories' => 'No categories found.',
        'add_category_link' => 'Add Category',
        'gallery_help' => 'You can select multiple images',
        'select_multiple' => 'Select multiple images',

        // Buttons
        'save_btn' => 'Save Post',
        'update_btn' => 'Update Post',
        'title' => 'Posts Management',
        'list' => 'Posts List',
        'add_new' => 'Add New Post',
        'article_title' => 'Post Title',
        'author' => 'Author',
        'status_published' => 'Published',
        'status_draft' => 'Draft',
    ],

    // 6. System Messages
    'messages' => [
        'success' => 'Success',
        'error' => 'Error',
        // Users
        'user_created' => 'User created and role assigned successfully',
        'user_updated' => 'User details updated successfully',
        'user_deleted' => 'User deleted successfully',
        'cannot_delete_self' => 'Sorry, you cannot delete your own account!',
        // Categories
        'category_created' => 'Category created successfully',
        'category_updated' => 'Category updated successfully',
        'category_deleted' => 'Category deleted successfully',
        // Posts
        'post_created' => 'Post created successfully',
        'post_updated' => 'Post updated successfully',
        'post_deleted' => 'Post deleted successfully',
    ],
    'settings' => [
        'title' => 'Site Settings',
        'site_email' => 'Site Email',
        'site_logo' => 'Site Logo (Logo)',
        'maintenance_mode' => 'Maintenance Mode',
        'site_name' => 'Site Name',
        'site_description' => 'Site Description',
        'copyright' => 'Copyright',
        'save_settings' => 'Save Settings',
        'on' => 'On',
        'off' => 'Off',
        'translated_content' => 'Translated Content',
        'system_settings' => 'System Settings',
        'save_settings' => 'Save Settings',
    ],
    'pages' => [
        'title' => 'Pages Management',
        'list' => 'Pages List',
        'add_new' => 'Add New Page',
        'edit_page' => 'Edit Page',
        'page_title' => 'Page Title',
        'content' => 'Page Content',
        'featured_image' => 'Featured Image',
    ],
    'auth' => [
        'login_title' => 'Login',
        'admin_panel' => 'Admin Control Panel',
        'email' => 'Email Address',
        'password' => 'Password',
        'remember_me' => 'Remember Me',
        'login_btn' => 'Login',
    ],
];
