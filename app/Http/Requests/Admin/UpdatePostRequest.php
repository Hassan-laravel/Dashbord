<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdatePostRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مخولاً بعمل هذا الطلب.
     */
    public function authorize(): bool
    {
        // 1. تأكد أن هذه true
        return true;
    }

    /**
     * قواعد التحقق.
     */
    public function rules(): array
    {
        $locale = app()->getLocale();

        // --- 2. التصحيح الأمني لجلب الـ ID ---
        $post = $this->route('post');
        // إذا كان $post كائناً نأخذ الـ id منه، وإذا كان رقماً نأخذه كما هو
        $postId = $post instanceof \App\Models\Post ? $post->id : $post;

        return [
            "$locale.title" => 'required|string|max:255',
            // استثناء المقال الحالي من فحص التكرار باستخدام الآيدي المستخرج
            "$locale.slug" => "nullable|string|max:255|unique:post_translations,slug,{$postId},post_id",
            "$locale.content" => 'nullable',

            // جعلنا التصنيفات اختيارية (nullable) لتجنب مشاكل إذا لم يختر المستخدم شيئاً
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'youtube_link' => 'nullable|url',
            'status' => 'required|in:published,draft',
        ];
    }
}
