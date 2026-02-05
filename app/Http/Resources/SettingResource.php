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
            // Static Data
            'email' => $this->site_email,
            'logo' => $this->site_logo ? \Illuminate\Support\Facades\Storage::disk('gcs')->url($this->site_logo) : null,
            'maintenance_mode' => (bool) $this->maintenance_mode,

            // Translated Data (Automatically changes based on middleware)
            'website_name' => $this->site_name,
            'description' => $this->site_description,
            'copyright' => $this->copyright,
        ];
    }
}
