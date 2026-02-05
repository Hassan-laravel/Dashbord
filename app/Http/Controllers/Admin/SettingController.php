<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\HandlesGcsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use HandlesGcsImage;

    public function index()
    {
        // Fetch settings (Always the first row)
        $setting = Setting::first();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::firstOrFail();

        // 1. Data Validation
        $rules = [
            'site_email' => 'nullable|email',
            'site_logo' => 'nullable|image|max:2048',
            'maintenance_mode' => 'nullable', // Checkbox sends a value or nothing
        ];

        // Validate translated fields
        foreach (config('language.supported') as $key => $lang) {
            $rules["$key.site_name"] = 'required|string|max:255';
            $rules["$key.site_description"] = 'nullable|string';
            $rules["$key.copyright"] = 'nullable|string';
        }

        $request->validate($rules);

        // 2. Prepare data for saving
        $data = $request->except(['site_logo', '_token']);

        // Handle Checkbox (If not selected, it defaults to 0)
        $data['maintenance_mode'] = $request->has('maintenance_mode') ? 1 : 0;

        // 3. Upload new logo
        if ($request->hasFile('site_logo')) {
            $imageResult = $this->updateImageInGcs($setting->site_logo ?? '', $request->file('site_logo'), 'settings');
            if ($imageResult) {
                $data['site_logo'] = $imageResult['path'];
            }
        }

        // 4. Save (The package automatically handles saving translated data into the translations table)
        $setting->update($data);

        return back()->with('success', __('dashboard.messages.settings_updated'));
    }
}
