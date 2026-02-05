<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array
    {
        // Get the ID of the user being edited to exclude it from the unique email check
        $userId = $this->route('user')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,

            // Password is optional during update
            'password' => 'nullable|min:6|confirmed',

            'role' => 'required|exists:roles,name',
        ];
    }
}
