<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function logout()
    {
        // Log out the user
        Auth::logout();

        // Redirect to the login page
        return redirect()->route('login')->with('success', 'Berhasil keluar!');
    }

    public function register(Request $request)
    {
        // Validate the registration data (password confirmation removed)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8', // No password confirmation required
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the user with a default role (role_id set to 2 for 'user')
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Assign role_id 2 ('user') by default
        ]);

        // Redirect to login page with a success message
        return redirect()->route('login')->with('success', 'Berhasil Mendaftar! Silahkan Masuk.');
    }

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Set alert message
        session()->flash('success', 'Login berhasil!');

        // Check role_id (1 for admin, 2 for user)
        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard');
        }

        // Default to user dashboard
        return redirect()->route('user.dashboard');
    }

    // Custom error messages based on the failed login attempt
    if (!User::where('email', $request->email)->exists()) {
        return back()->with('error', 'Email tidak ditemukan.');
    } elseif (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return back()->with('error', 'Password salah.');
    }

    return back()->with('error', 'Invalid credentials');
}




}
