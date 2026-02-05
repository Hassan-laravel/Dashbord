<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            // --- 1. Translated Data (Based on Frontend locale) ---
            'title' => $this->title,          // Fetched from post_translations
            'content' => $this->content,      // Fetched from post_translations
            'slug' => $this->slug,            // Fetched from post_translations
            'excerpt' => mb_substr(strip_tags($this->content ?? ''), 0, 150) . '...',

            // --- 2. Post Featured Image ---
            'main_image' => $this->image ? \Illuminate\Support\Facades\Storage::disk('gcs')->url($this->image) : null,

            // --- 3. Gallery Images (post_images) ---
            'gallery' => $this->images->map(function ($img) {
                return [
                    'id' => $img->id,
                    'url' => \Illuminate\Support\Facades\Storage::disk('gcs')->url($img->image_path),
                ];
            }),

            'categories' => CategoryResource::collection($this->whenLoaded('categories')),

            // --- 4. Additional Information ---
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
