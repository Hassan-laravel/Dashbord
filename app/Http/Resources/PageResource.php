<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'title' => $this->title,          // Automatically translated
            'slug' => $this->slug,            // Automatically translated
            'content' => $this->content,      // Automatically translated

            // Featured Image
            'image' => $this->image ? \Illuminate\Support\Facades\Storage::disk('gcs')->url($this->image) : null,

            // SEO Data
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
            ]
        ];
    }
}
