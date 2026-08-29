<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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


    public function showSettings()
{
    return view('account.admin.profile-settings', ['user' => Auth::user()]);
}

public function updateProfile(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);

    Auth::user()->update([
        'name' => $validated['name'],
    ]);

    return back()->with('status', 'Profile name updated successfully.');
}

/**
 * 3. Safely Change Account Email Address
 */
public function changeEmail(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'current_password' => ['required', 'string'],
    ]);

    // Security Verification Check: Confirm identity before swapping sensitive data
    if (!Hash::check($validated['current_password'], $user->password)) {
        return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
    }

    $user->update([
        'email' => $validated['email'],
        'email_verified_at' => null, // Resets status if you want them to verify the new address via OTP later
    ]);

    return back()->with('status', 'Email address successfully updated.');
}

/**
 * 4. Change Account Phone Number Data
 */
public function changePhone(Request $request)
{
    $validated = $request->validate([
        'phone' => ['required', 'string', 'max:20'],
    ]);

    Auth::user()->update([
        'phone' => $validated['phone'],
    ]);

    return back()->with('status', 'Phone number successfully updated.');
}

    /**
     * 5. Update/Change Security Access Password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'], // Laravel built-in current validation rule verification
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'Password modified successfully.');
    }

    /**
     * 6. Permanently Delete Account
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            Auth::logout();
            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('show.login')->with('status', 'Your account has been permanently deleted.');
    }
}