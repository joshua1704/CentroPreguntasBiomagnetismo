<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin() {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = auth()->user();

            if (!$user->is_admin) {
                Auth::logout();
                return redirect()
                    ->route('admin_login')
                    ->withErrors([
                    'login' => __('validator.login_not_access'),
                ]);
            }

            return redirect()->route('admin_get_questions', 'pending');
        }

        return back()->withErrors([
            'login' => __('validator.login_not_attempt'),
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin_login');
    }

    public function showChangePassword()
    {
        return view('admin.auth.changePassword');
    }

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
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
            'password.required' => __('validator.password_required'),
            'password.confirmed' => __('validator.password_confirmed'),
            'password.min' => __('validator.password_min')
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('admin_get_questions', 'pending');
    }
}
