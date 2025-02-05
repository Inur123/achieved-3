<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // Mendapatkan informasi pengguna dari Google
        $socialUser = Socialite::driver('google')->user();

        // Cek apakah pengguna sudah terdaftar dengan Google ID atau email
        $existingUser = User::where('google_id', $socialUser->id)
                            ->orWhere('email', $socialUser->email)
                            ->first();

        if ($existingUser) {
            // Jika pengguna sudah terdaftar, login ke aplikasi
            Auth::login($existingUser);

            session()->flash('success', 'Login berhasil!');

            // Arahkan berdasarkan role_id
            if ($existingUser->role_id == 1) {
                return redirect()->route('admin.dashboard'); // Halaman dashboard admin
            }

            // Default ke dashboard user
            return redirect()->route('user.dashboard'); // Halaman dashboard user
        }

        // Jika pengguna belum terdaftar, buat pengguna baru
        $user = User::create([
            'google_id' => $socialUser->id,
            'name' => $socialUser->name,
            'email' => $socialUser->email,
            'password' => Hash::make('password'),  // Password acak
            'google_token' => $socialUser->token,
            'google_refresh_token' => $socialUser->refreshToken,
        ]);

        // Login pengguna yang baru dibuat
        Auth::login($user);

        session()->flash('success', 'Login berhasil!');
        // Arahkan berdasarkan role_id
        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard'); // Halaman dashboard admin
        }

        // Default ke dashboard user
        return redirect()->route('user.dashboard'); // Halaman dashboard user
    }
}
