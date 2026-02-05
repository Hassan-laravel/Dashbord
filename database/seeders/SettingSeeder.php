<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // We use updateOrCreate to ensure only one settings record exists (ID = 1)
        // If it exists, it will be updated; otherwise, it will be created.

        Setting::updateOrCreate(
            ['id' => 1], // Condition: Search for setting with ID 1
            [
                // 1. Static data (settings table)
                'site_email' => 'admin@example.com',
                'site_logo' => null, // A default image path can be placed here
                'maintenance_mode' => false,

                // 2. Translated data (setting_translations table)
                // The package allows adding translations directly as an array using the language code.

                'ar' => [
                    'site_name' => 'اسم الموقع بالعربية',
                    'site_description' => 'هذا وصف افتراضي للموقع يظهر في محركات البحث ووسائل التواصل الاجتماعي.',
                    'copyright' => 'جميع الحقوق محفوظة © ' . date('Y'),
                ],

                'en' => [
                    'site_name' => 'English Site Name',
                    'site_description' => 'This is a default description for the website used for SEO.',
                    'copyright' => 'All rights reserved © ' . date('Y'),
                ],
            ]
        );
    }
}
