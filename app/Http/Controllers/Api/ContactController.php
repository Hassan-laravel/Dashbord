<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // 1. التحقق من البيانات القادمة
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. تخزين البيانات في جدول contact
        $contact = Contact::create($validator->validated());

        // 3. إرجاع استجابة نجاح
        return response()->json([
            'status' => 'success',
            'message' => 'Message stored successfully',
            'data' => $contact
        ], 201);
    }
}
