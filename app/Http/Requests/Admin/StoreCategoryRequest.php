<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize() { return true; }

  public function rules(): array
    {
        // استخراج ID التصنيف
        $category = $this->route('category');
        $id = $category instanceof \Illuminate\Database\Eloquent\Model ? $category->id : $category;

        // تحديد اللغة الحالية فقط
        $locale = app()->getLocale();

        return [
            'status' => 'required|in:0,1',

            // قواعد التحقق للغة الحالية فقط
            "$locale.name" => 'required|string|max:255',
            // التحقق من الرابط مع استثناء التصنيف الحالي
            "$locale.slug" => "nullable|string|max:255|unique:category_translations,slug,{$id},category_id",
            "$locale.meta_title" => 'nullable|string|max:255',
            "$locale.meta_description" => 'nullable|string',
        ];
    }
}
