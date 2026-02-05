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
    // Display a listing of users
    public function index()
    {
        // Fetch users with their roles (to prevent the N+1 query problem)
        $users = User::with('roles')->latest()->paginate(10);

        // Fetch roles to display in the dropdown list within the modal
        $roles = Role::pluck('name');

        return view('admin.users.index', compact('users', 'roles'));
    }

    // Save a new user
    public function store(StoreUserRequest $request)
    {
        // 1. Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Assign role (permission)
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')
           ->with('success', __('dashboard.messages.user_created'));
    }

    // Fetch user data (for AJAX - when clicking the edit button)
    // No separate edit page is needed since we are using a Modal
    public function edit(User $user)
    {
        // Return data as JSON for JavaScript to read and populate the modal
        return response()->json([
            'user' => $user,
            'role' => $user->roles->first()->name ?? ''
        ]);
    }

    // Update user data
    public function update(UpdateUserRequest $request, User $user)
    {
        // 1. Update basic information
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // 2. Update password only if it was provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // 3. Sync role (removes the old role and adds the new one)
        $user->syncRoles($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', __('dashboard.messages.user_updated'));
    }

    // Delete a user
    public function destroy(User $user)
    {
        // Protection: An admin cannot delete their own account
        if (Auth::id() == $user->id) {
           return back()->with('error', __('dashboard.messages.cannot_delete_self'));
        }

        $user->delete();
       return back()->with('success', __('dashboard.messages.user_deleted'));
    }
}
