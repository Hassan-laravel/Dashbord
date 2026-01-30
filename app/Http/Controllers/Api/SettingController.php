<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    public function index()
    {
        // جلب الصف الأول (والوحيد) من جدول الإعدادات
        $setting = Setting::firstOrFail();

        return new SettingResource($setting);
    }
}
