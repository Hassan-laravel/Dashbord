<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array
    {
        // Extract Category ID
        $category = $this->route('category');
        $id = $category instanceof \Illuminate\Database\Eloquent\Model ? $category->id : $category;

        // Define the current locale only
        $locale = app()->getLocale();

        return [
            'status' => 'required|in:0,1',

            // Validation rules for the current locale only
            "$locale.name" => 'required|string|max:255',

            // Validate slug while excluding the current category ID
            "$locale.slug" => "nullable|string|max:255|unique:category_translations,slug,{$id},category_id",
            "$locale.meta_title" => 'nullable|string|max:255',
            "$locale.meta_description" => 'nullable|string',
        ];
    }
}
