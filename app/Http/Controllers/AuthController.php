<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // CEK BAGIAN INI:
            if (Auth::user()->role == 'admin') {
                // Ganti dari 'kasir.index' ke 'dashboard'
                return redirect()->intended(route('dashboard'));
            }

            // Untuk pembeli/user biasa
            return redirect()->intended(route('homepage'));
        }

        return back()->with('loginError', 'Login Gagal');
    }

    public function register(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed', // 'confirmed' butuh input password_confirmation
    ]);

    // 2. Simpan ke Database
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'pembeli', // Otomatis jadi pembeli
    ]);

    // 3. Langsung loginin atau lempar ke login
    return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
