<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $patientRole = Role::where('name', 'patient')->firstOrFail();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
            'role_id' => $patientRole->id,
        ]);

        return redirect()
            ->route('show.login')
            ->with('status', 'Account created. Please log in.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Validate login information
        |--------------------------------------------------------------------------
        */

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Find the user by email
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $credentials['email'])->first();

        /*
        |--------------------------------------------------------------------------
        | 3. Check if the user exists
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'User not found.',
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Check the password
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'Incorrect password.',
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Log the user in
        |--------------------------------------------------------------------------
        */

        $remember = $request->filled('remember');

        Auth::login($user, $remember);

        /*
        |--------------------------------------------------------------------------
        | 6. Regenerate the session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | 7. Redirect to the user dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}