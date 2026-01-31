<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,          // مترجم تلقائياً
            'slug' => $this->slug,            // مترجم تلقائياً
            'content' => $this->content,      // مترجم تلقائياً

            // الصورة البارزة
            'image' => $this->image ? \Illuminate\Support\Facades\Storage::disk('gcs')->url($this->image) : null,

            // بيانات SEO
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
            ]
        ];
    }
}
