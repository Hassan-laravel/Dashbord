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
        // 1. Create Permissions
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

        // 2. Create Roles
        $editorRole = Role::create(['name' => 'Editor']);
        // $editorRole->givePermissionTo(['create posts', 'edit posts', 'delete posts']);
        $editorRole->givePermissionTo(['create posts', 'edit posts']);

        $adminRole = Role::create(['name' => 'Super Admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 3. Create Users (Note how we store them in variables for later use)
        $admin = User::create([
            'name' => 'Main Admin',
            'email' => 'admin@app.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Super Admin');

        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@app.com',
            'password' => Hash::make('password'),
        ]);
        $editor->assignRole('Editor');

        // 4. Create a Category and store it in a variable
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

        // 5. Create a Post (Using variables instead of hardcoded IDs)
        \App\Models\Post::create([
            'user_id' => $admin->id, // <--- Adjustment here: Fetching ID from the variable
            'category_id' => $category->id, // <--- Fetching Category ID from the variable
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
