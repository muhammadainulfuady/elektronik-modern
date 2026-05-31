<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            return match ($user->role) {
                'admin' => redirect()->route('admin.index'),
                'owner' => redirect()->route('owner.index'),
                default => redirect()->route('index')->with('status', 'Selamat datang, ' . $user->nama . '!'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function verifyForgotPasswordEmail(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email tidak ditemukan pada sistem.',
        ]);

        $request->session()->put('reset_password_email', $data['email']);

        return redirect()->route('password.reset.form');
    }

    public function showResetPassword(Request $request)
    {
        if (!$request->session()->has('reset_password_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', [
            'email' => $request->session()->get('reset_password_email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $email = $request->session()->get('reset_password_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        $data = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('email', $email)->firstOrFail();
        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        $request->session()->forget('reset_password_email');

        return redirect()
            ->route('login')
            ->with('status', 'Password berhasil diperbarui. Silakan login dengan password baru.');
    }

    /**
     * Tampilkan form register.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
