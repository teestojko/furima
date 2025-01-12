<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $admin = Admin::where('email', $credentials['email'])->first();
            if (!$admin) {
            return back()->withErrors([
                'email' => 'メールアドレスまたはパスワードが一致しません.',
            ]);
            }
            if (!Hash::check($credentials['password'], $admin->password)) {
            return back()->withErrors([
                'password' => 'パスワードが一致しません.',
            ]);
            }
            if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin-dashboard');
            }
    }
}
