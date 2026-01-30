<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
        "$locale.content" => 'required', // المحتوى
        'categories' => 'required|array', // مصفوفة تصنيفات
        'categories.*' => 'exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // الصورة الرئيسية
        'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // الصور الفرعية
        'youtube_link' => 'nullable|url',
        'status' => 'required|in:published,draft',
    ];
}
}
