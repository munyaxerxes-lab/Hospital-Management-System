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
            'password' => Hash::make($validated['password']),
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

        $remember = $request->filled('remember');

        /*
        |--------------------------------------------------------------------------
        | 2. Securely authenticate via Native Laravel Attempt
        |--------------------------------------------------------------------------
        */
        if (Auth::attempt($credentials, $remember)) {
            
            // Regenerate session to protect against session fixation attacks
            $request->session()->regenerate();
            
            // Get the authenticated user record
            $user = Auth::user();

            /*
            |--------------------------------------------------------------------------
            | 3. Dynamic Multi-Role Workspace Redirection
            |--------------------------------------------------------------------------
            | Checks your database relation names to assign proper route folders
            */
            if ($user->role && $user->role->name === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Default safe workspace fall-back path for Patients
            return redirect()->route('patient.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Return secure failed attempt notices
        |--------------------------------------------------------------------------
        */
        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}