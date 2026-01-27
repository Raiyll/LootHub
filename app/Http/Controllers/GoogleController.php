<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            // 1. Cari user (termasuk yang di-soft delete sesuai instruksi)
            $finduser = User::withTrashed()
                ->where('email', $user->email)
                ->first();

            if ($finduser) {
                // 2. Jika ketemu data lama tapi terhapus, aktifkan kembali
                if ($finduser->trashed()) {
                    $finduser->restore();
                }

                // Sync google_id jika belum ada
                $finduser->update(['google_id' => $user->id]);

                Auth::login($finduser);
            } else {
                // 3. Register baru dengan role 'pembeli'
                $newUser = User::create([
                    'name'      => $user->name,
                    'email'     => $user->email,
                    'google_id' => $user->id,
                    'role'      => 'pembeli',
                    'password'  => encrypt('123456dummy')
                ]);
                Auth::login($newUser);
            }

            // 4. PENGALIHAN (REDIRECT) - Pastikan nama route ini ada di web.php
            $role = Auth::user()->role;

            if ($role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role == 'kasir') {
                return redirect()->route('kasir.dashboard');
            }

            // Default: Kirim ke Landing Page (Pastikan route 'home' ada!)
            return redirect('/');
        } catch (Exception $e) {
            // Kalau gagal login, munculin pesan error aslinya buat debug
            return redirect('login')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
