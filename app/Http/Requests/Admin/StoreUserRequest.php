<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', // confirmed تعني يجب تطابق حقل password_confirmation
            'role' => 'required|exists:roles,name', // التأكد من أن الدور موجود في قاعدة البيانات
        ];
    }
}
