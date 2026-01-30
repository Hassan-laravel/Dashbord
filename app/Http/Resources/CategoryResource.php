<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name, // سيتم جلب الاسم مترجماً تلقائياً
            'slug' => $this->slug,
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
            ],
        ];
    }
}
