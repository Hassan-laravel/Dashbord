<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $locale = app()->getLocale();

        return [
            "$locale.title" => 'required|string|max:255',
            "$locale.slug" => "nullable|string|max:255|unique:post_translations,slug",

            // Content field
            "$locale.content" => 'required',

            // Array of category IDs
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',

            // Featured Image
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Gallery/Secondary images
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'youtube_link' => 'nullable|url',
            'status' => 'required|in:published,draft',
        ];
    }
}
