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

            // "confirmed" means the password_confirmation field must match
            'password' => 'required|min:6|confirmed',

            // Ensures the role exists in the database
            'role' => 'required|exists:roles,name',
        ];
    }
}
