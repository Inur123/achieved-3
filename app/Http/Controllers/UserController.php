<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Fetch all users or you can customize it based on your needs
        $users = User::all();

        // Return the view with user data
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        // Return the view to create a new user
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create a new user with hashed password
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hash the password
        ]);

        // Redirect to the user index page with a success message
        return redirect()->route('admin.user.index')->with('success', 'User created successfully.');
    }


    public function edit(User $user)
    {
        // Return the view to edit the user
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
{
    // Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8', // Only validate password if provided
    ]);

    // Update the user with the hashed password if provided
    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => isset($validated['password']) ? Hash::make($validated['password']) : $user->password, // Hash if new password is given
    ]);

    // Redirect to the user index page with a success message
    return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
}


    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        // Redirect to the user index page with a success message
        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
    }
}
