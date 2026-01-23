<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                // Jika admin → ke dashboard
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                // Jika ada "redirect=url"
                if ($request->has('redirect')) {
                    return redirect()->to($request->query('redirect'));
                }

                // Balik ke halaman sebelumnya
                return redirect()->back();
            }

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses register
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|unique:users,username|max:50',
                'email' => 'required|email|unique:users,email',
                'no_hp' => 'nullable|string|max:20',
                'password' => 'required|string|min:3|confirmed',
                'role' => 'in:admin,customer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validasi file image
            ]);

            // Simpan file image jika ada
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public');
            } else {
                $imagePath = null;
            }

            User::create([
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'customer',
                'image' => $imagePath,
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat registrasi: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
