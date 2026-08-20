<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Check email and password
        $request->authenticate();

        // Find the user
        $user = User::where('email', $request->email)->first();

        // Generate a 6-digit OTP
        $otp = (string) random_int(100000, 999999);

        // OTP expires after 1 minutes
        $otpExpiresAt = now()->addMinutes(1);

        // Save OTP and expiration time
        $user->forceFill([
            'otp_code' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ])->save();

        // Store the user ID temporarily in the session
        $request->session()->put('login_otp_user_id', $user->id);

        // Send OTP to the user's email
        Mail::raw(
            "Your MediLink login verification code is: {$otp}\n\n"
            . "This code will expire in 1 minutes.",
            function ($message) use ($user) {
                $message
                    ->to($user->email)
                    ->subject('MediLink Login Verification Code');
            }
        );

        // Redirect to login OTP verification page
        return redirect()->route('login.verify-otp');
    }

    /**
     * Display the login OTP verification page.
     */
    public function showLoginOtp(): View
    {
        return view('auth.login-otp');
    }

    /**
     * Verify the login OTP.
     */
    public function verifyLoginOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        // Get the user waiting for login verification
        $userId = $request->session()->get('login_otp_user_id');

        if (!$userId) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'otp' => 'Your login session has expired. Please login again.',
                ]);
        }

        // Find the user
        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget('login_otp_user_id');

            return redirect()
                ->route('login')
                ->withErrors([
                    'otp' => 'User account could not be found. Please login again.',
                ]);
        }

        // Check OTP
        if (
            $user->otp_code != $request->otp ||
            !$user->otp_expires_at ||
            now()->greaterThan($user->otp_expires_at)
        ) {
            return back()->withErrors([
                'otp' => 'The OTP is invalid or has expired.',
            ]);
        }

        // OTP is correct — authenticate the user
        Auth::login($user);

        // Regenerate session for security
        $request->session()->regenerate();

        // Remove temporary login OTP session data
        $request->session()->forget('login_otp_user_id');

        // Clear OTP from database
        $user->forceFill([
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();

        // Redirect normal user to patient dashboard
        return redirect()->route('user.dashboard');
    }

    /**
     * Resend a new OTP during login verification.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        // Get the user waiting for login verification
        $userId = $request->session()->get('login_otp_user_id');

        if (!$userId) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'otp' => 'Your login session has expired. Please login again.',
                ]);
        }

        // Find the user
        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget('login_otp_user_id');

            return redirect()
                ->route('login')
                ->withErrors([
                    'otp' => 'User account not found. Please login again.',
                ]);
        }

        // Generate a new 6-digit OTP
        $otp = (string) random_int(100000, 999999);

        // New OTP expires after 1 minutes
        $otpExpiresAt = now()->addMinutes(1);

        // Save the new OTP
        $user->forceFill([
            'otp_code' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ])->save();

        // Send the new OTP to the user's email
        Mail::raw(
            "Your new MediLink login verification code is: {$otp}\n\n"
            . "This code will expire in 5 minutes.",
            function ($message) use ($user) {
                $message
                    ->to($user->email)
                    ->subject('MediLink New Login Verification Code');
            }
        );

        // Return to the OTP page with a success message
        return back()->with(
            'status',
            'A new verification code has been sent to your email.'
        );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}