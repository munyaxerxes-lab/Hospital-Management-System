<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        // Generate a 6-digit OTP
        $otp = (string) random_int(100000, 999999);

        // OTP expires after 1 minute
        $otpExpiresAt = now()->addMinute();

        // Create the user with a default role assignment
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3, //missing default error
        ]);

        // Save OTP information
        $user->forceFill([
            'otp_code' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ])->save();

        // Send OTP to the user's email
        Mail::raw(
            "Your MediLink verification code is: {$otp}\n\n"
            . "This code will expire in 1 minute.",
            function ($message) use ($user) {
                $message
                    ->to($user->email)
                    ->subject('MediLink Email Verification Code');
            }
        );

        // Remember which user is currently waiting for OTP verification
        $request->session()->put('pending_verification_user_id', $user->id);

        // Send the user to the OTP verification page
        return redirect()->route('register.verify-otp');
    }

    /**
     * Display the registration OTP verification page.
     */
    public function showVerifyOtp(Request $request): View
    {
        // Make sure there is a user waiting for verification
        if (!$request->session()->has('pending_verification_user_id')) {
            return redirect()->route('register');
        }

        return view('auth.register-otp');
    }

    /**
     * Verify the OTP sent during registration.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $userId = $request->session()->get('pending_verification_user_id');

        if (!$userId) {
            return redirect()
                ->route('register')
                ->withErrors([
                    'otp' => 'Your verification session has expired. Please register again.',
                ]);
        }

        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget('pending_verification_user_id');

            return redirect()
                ->route('register')
                ->withErrors([
                    'otp' => 'User account not found. Please register again.',
                ]);
        }

        // Check whether the OTP has expired
        if (!$user->otp_expires_at || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors([
                'otp' => 'This verification code has expired. Please register again.',
            ]);
        }

        // Check whether the OTP is correct
        if ($user->otp_code !== $request->otp) {
            return back()->withErrors([
                'otp' => 'The verification code is incorrect.',
            ]);
        }

        // OTP is correct — clear it so it cannot be reused
        $user->forceFill([
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();

        // Remove pending verification session
        $request->session()->forget('pending_verification_user_id');

        // Log the user in
        Auth::login($user);

        // Regenerate the session for security
        $request->session()->regenerate();

        // Send the verified user directly to the dashboard
       return redirect()->route('user.dashboard');
    }

    /**
     * Resend a new OTP during registration verification.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        // Get the user waiting for verification
        $userId = $request->session()->get('pending_verification_user_id');

        if (!$userId) {
            return redirect()
                ->route('register')
                ->withErrors([
                    'otp' => 'Your verification session has expired. Please register again.',
                ]);
        }

        // Find the user
        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget('pending_verification_user_id');

            return redirect()
                ->route('register')
                ->withErrors([
                    'otp' => 'User account not found. Please register again.',
                ]);
        }

        // Generate a new 6-digit OTP
        $otp = (string) random_int(100000, 999999);

        // New OTP expires after 1 minute
        $otpExpiresAt = now()->addMinute();

        // Save the new OTP
        $user->forceFill([
            'otp_code' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ])->save();

        // Send the new OTP to the user's email
        Mail::raw(
            "Your new MediLink verification code is: {$otp}\n\n"
            . "This code will expire in 1 minute.",
            function ($message) use ($user) {
                $message
                    ->to($user->email)
                    ->subject('MediLink New Verification Code');
            }
        );

        // Return to the OTP page
        return back()->with(
            'status',
            'A new verification code has been sent to your email.'
        );
    }
}
