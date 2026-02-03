<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            // JSON response untuk AJAX
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil!',
                'redirect' => $role === 'admin' ? route('admin.dashboard') : route('home')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Email atau password salah!'
        ], 422);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'required|string|min:3|confirmed',
            'role' => 'in:admin,customer',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'customer',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil! Silakan login.',
            'redirect' => route('login')
        ]);
    }

   public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Set session flash agar toast muncul di halaman login/home
    return redirect()->route('home')->with('logout_success', true);
}

}
