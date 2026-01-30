<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // عرض قائمة المستخدمين
    public function index()
    {
        // جلب المستخدمين مع أدوارهم (لمنع مشكلة N+1 query)
        $users = User::with('roles')->latest()->paginate(10);

        // جلب الأدوار لعرضها في قائمة الاختيار (Dropdown) داخل المودال
        $roles = Role::pluck('name');

        return view('admin.users.index', compact('users', 'roles'));
    }

    // حفظ مستخدم جديد
    public function store(StoreUserRequest $request)
    {
        // 1. إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. تعيين الدور (الصلاحية)
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')
           ->with('success', __('dashboard.messages.user_created'));
    }

    // جلب بيانات مستخدم (للأجاكس - عند الضغط على زر تعديل)
    // لا نحتاج لصفحة تعديل منفصلة لأننا نستخدم Modal
    public function edit(User $user)
    {
        // نعيد البيانات كـ JSON ليقرأها الجافاسكربت ويملأ المودال
        return response()->json([
            'user' => $user,
            'role' => $user->roles->first()->name ?? ''
        ]);
    }

    // تحديث بيانات المستخدم
    public function update(UpdateUserRequest $request, User $user)
    {
        // 1. تحديث البيانات الأساسية
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // 2. تحديث كلمة المرور فقط إذا تم إدخالها
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // 3. مزامنة الدور (حذف القديم وإضافة الجديد)
        $user->syncRoles($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', __('dashboard.messages.user_updated'));
    }

    // حذف المستخدم
    public function destroy(User $user)
    {
        // حماية: لا يمكن للمدير حذف نفسه
        if (Auth::id() == $user->id) {
           return back()->with('error', __('dashboard.messages.cannot_delete_self'));
        }

        $user->delete();
       return back()->with('success', __('dashboard.messages.user_deleted'));
    }
}
