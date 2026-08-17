<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Every normal registration creates a patient
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
        // Validate login form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember');

        // Attempt authentication FIRST
        if (Auth::attempt($credentials, $remember)) {

            // Prevent session fixation
            $request->session()->regenerate();

            // Now the authenticated user exists
            $user = Auth::user();

            // Make sure the user has a role
            if (!$user->role) {
                Auth::logout();

                return redirect()
                    ->route('show.login')
                    ->withErrors([
                        'email' => 'No role assigned to this account.',
                    ]);
            }

            // Redirect according to role
            switch ($user->role->name) {

                case 'patient':
                    return redirect()->route('patient.dashboard');

                case 'doctor':
                    return redirect()->route('doctor.dashboard');

                case 'admin':
                    return redirect()->route('admin.dashboard');

                case 'pharmacist':
                    return redirect()->route('pharmacist.dashboard');

                case 'lab_technician':
                    return redirect()->route('lab.dashboard');

                case 'DeliveryAgent':
                    return redirect()->route('delivery.dashboard');

                default:
                    Auth::logout();

                    return redirect()
                        ->route('show.login')
                        ->withErrors([
                            'email' => 'Invalid user role.',
                        ]);
            }
        }

        // Login failed
        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    public function deleteAccount(Request $request)
{
    // 1. Get the currently logged-in user
    $user = Auth::user();

    // 2. Clear out the active login session first
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // 3. Permanently delete the user from the database
    if ($user) {
        $user->delete();
    }

    // 4. Redirect them to the login page with a success flash message
    return redirect()
        ->route('show.login')
        ->with('status', 'Your account has been permanently deleted.');
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('show.login');
    }
}