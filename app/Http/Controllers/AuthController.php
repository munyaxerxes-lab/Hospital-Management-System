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

        $patientRole = Role::where('name', 'patient')->firstOrFail();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
            'role_id' => $patientRole->id,
        ]);

        return redirect()->route('show.login')->with('status', 'Account created. Please log in.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $user = Auth::user();

        switch ($user->role_id) {

            case 1:
                return redirect()->route('patient.dashboard');

            case 2:
                return redirect()->route('doctor.dashboard');

            case 3:
                return redirect()->route('admin.dashboard');

            case 4:
                return redirect()->route('pharmacist.dashboard');

            case 5:
                return redirect()->route('lab.dashboard');

            case 6:
                return redirect()->route('delivery.dashboard');

            default:
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Invalid user role.']);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/user');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}