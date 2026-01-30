<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء الصلاحيات
        $permissions = [
            'create posts',
            'edit posts',
            'delete posts',
            'manage users',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 2. إنشاء الأدوار
        $editorRole = Role::create(['name' => 'Editor']);
        // $editorRole->givePermissionTo(['create posts', 'edit posts', 'delete posts']);
       $editorRole->givePermissionTo(['create posts', 'edit posts']);

        $adminRole = Role::create(['name' => 'Super Admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 3. إنشاء المستخدمين (لاحظ كيف نحتفظ بهم في متغيرات)
        $admin = User::create([
            'name' => 'المدير العام',
            'email' => 'admin@app.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Super Admin');

        $editor = User::create([
            'name' => 'سعيد المحرر',
            'email' => 'editor@app.com',
            'password' => Hash::make('password'),
        ]);
        $editor->assignRole('Editor');

        // 4. إنشاء تصنيف وتخزينه في متغير
        $category = \App\Models\Category::create([
            'status' => true,
            'ar' => [
                'name' => 'تكنولوجيا',
                'slug' => 'tech-ar',
                'meta_title' => 'أخبار التكنولوجيا',
                'meta_description' => 'وصف التكنولوجيا'
            ],
            'en' => [
                'name' => 'Technology',
                'slug' => 'tech-en',
                'meta_title' => 'Tech News',
                'meta_description' => 'Tech Description'
            ],
        ]);

        // 5. إنشاء المنشور (استخدام المتغيرات بدلاً من الأرقام الثابتة)
        \App\Models\Post::create([
            'user_id' => $admin->id, // <--- التعديل هنا: نأخذ الآيدي من المتغير
            'category_id' => $category->id, // <--- ونأخذ آيدي التصنيف من المتغير
            'status' => 'published',
            'ar' => [
                'title' => 'عنوان المقال الأول',
                'content' => 'محتوى تجريبي',
                'slug' => 'first-post-ar'
            ],
            'en' => [
                'title' => 'First Post Title',
                'content' => 'Demo content',
                'slug' => 'first-post-en'
            ],
        ]);
    }
}
