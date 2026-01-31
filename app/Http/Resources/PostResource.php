<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            // --- 1. البيانات المترجمة (حسب لغة الـ Frontend) ---
            'title' => $this->title,          // سيأتي من post_translations
            'content' => $this->content,      // سيأتي من post_translations
            'slug' => $this->slug,            // سيأتي من post_translations
            'excerpt' => mb_substr(strip_tags($this->content ?? ''), 0, 150) . '...',

            // --- 2. الصورة الرئيسية للمقال ---
            'main_image' => $this->image ? \Illuminate\Support\Facades\Storage::disk('gcs')->url($this->image) : null,

            // --- 3. صور المعرض (post_images) ---
            'gallery' => $this->images->map(function ($img) {
                return [
                    'id' => $img->id,
                    'url' => \Illuminate\Support\Facades\Storage::disk('gcs')->url($img->image_path),
                ];
            }),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            // --- 4. بيانات إضافية ---
            'author' => $this->author->name ?? 'Admin',
            'created_at' => $this->created_at->format('Y-m-d'),

            // SEO
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
            ]
        ];
    }
}
