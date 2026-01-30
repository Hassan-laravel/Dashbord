<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // البيانات الثابتة
            'email' => $this->site_email,
            'logo' => $this->site_logo ? asset('storage/' . $this->site_logo) : null,
            'maintenance_mode' => (bool) $this->maintenance_mode,

            // البيانات المترجمة (تتغير تلقائياً حسب الميدل وير)
            'website_name' => $this->site_name,
            'description' => $this->site_description,
            'copyright' => $this->copyright,
        ];
    }
}
