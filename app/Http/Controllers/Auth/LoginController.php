<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Tampilkan form login pelanggan
     */
    public function showLoginFormPelanggan()
    {
        return view('auth.login-pelanggan');
    }

    /**
     * Tampilkan form login admin/owner
     */
    public function showLoginFormAdmin()
    {
        return view('auth.login-admin');
    }

    /**
     * Proses login pelanggan
     */
    public function loginPelanggan(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (!Auth::user()->isPelanggan()) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun ini bukan akun pelanggan.',
                ]);
            }

            return redirect()->route('pelanggan.beranda');
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Proses login admin/owner
     */
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->isOwner()) {
                return redirect()->route('owner.dashboard');
            }

            // Jika pelanggan coba login di sini, tolak
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Akun ini bukan akun admin/owner.',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Logout (digunakan semua role)
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}