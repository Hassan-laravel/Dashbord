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
        // نستخدم updateOrCreate للتأكد من وجود إعدادات واحدة فقط (ID = 1)
        // إذا كان موجوداً سيتم تحديثه، وإذا لم يكن سيتم إنشاؤه

        Setting::updateOrCreate(
            ['id' => 1], // الشرط: البحث عن الإعداد رقم 1
            [
                // 1. البيانات الثابتة (settings table)
                'site_email' => 'admin@example.com',
                'site_logo' => null, // يمكن وضع مسار صورة افتراضية هنا
                'maintenance_mode' => false,

                // 2. البيانات المترجمة (setting_translations table)
                // تتيح الحزمة إضافة الترجمات مباشرة كمصفوفة باستخدام كود اللغة

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
