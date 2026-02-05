<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // 1. Ensure this is set to true
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $locale = app()->getLocale();

        // --- 2. Security fix to retrieve the ID ---
        $post = $this->route('post');

        // If $post is an object, we take the id from it; if it's a number, we take it as is
        $postId = $post instanceof \App\Models\Post ? $post->id : $post;

        return [
            "$locale.title" => 'required|string|max:255',

            // Exclude the current post from the unique slug check using the extracted ID
            "$locale.slug" => "nullable|string|max:255|unique:post_translations,slug,{$postId},post_id",

            "$locale.content" => 'nullable',

            // Categories are made nullable to prevent issues if the user selects nothing
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'youtube_link' => 'nullable|url',
            'status' => 'required|in:published,draft',
        ];
    }
}
