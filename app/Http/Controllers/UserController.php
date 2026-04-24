<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $sidebar = "users";
        $users = DB::table('users')
            ->select('users.id', 'users.name', 'users.username', 'users.created_at', 'users.is_admin')
            ->get();
        return view('admin.pages.users', compact('sidebar', 'users'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|unique:users,username',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                function($attribute, $value, $fail) {
                    // letters (al menos una letra)
                    if (!preg_match('/[a-zA-Z]/', $value)) {
                        $fail(__('validator.password_letters'));
                    }

                    // mixedCase (mayúsculas y minúsculas)
                    if (!preg_match('/[A-Z]/', $value) || !preg_match('/[a-z]/', $value)) {
                        $fail(__('validator.password_mixedcase'));
                    }

                    // numbers
                    if (!preg_match('/[0-9]/', $value)) {
                        $fail(__('validator.password_numbers'));
                    }

                    // symbols
                    if (!preg_match('/[\W_]/', $value)) {
                        $fail(__('validator.password_symbols'));
                    }
                }
            ]
        ], [
            'name.required' => __('validator.name_requiered'),
            'name.string' => __('validator.name_string'),
            'username.required' => __('validator.username_required'),
            'username.unique' => __('validator.username_unique'),
            'password.required' => __('validator.password_required'),
            'password.confirmed' => __('validator.password_confirmed'),
            'password.min' => __('validator.password_min')
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'is_admin' => true,
            'must_change_password' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back();
    }
}
