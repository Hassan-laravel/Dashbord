<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array
    {
        // نحصل على الـ ID الخاص بالمستخدم المراد تعديله لاستثنائه من فحص التكرار
        $userId = $this->route('user')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|min:6|confirmed', // كلمة المرور اختيارية عند التعديل
            'role' => 'required|exists:roles,name',
        ];
    }
}
