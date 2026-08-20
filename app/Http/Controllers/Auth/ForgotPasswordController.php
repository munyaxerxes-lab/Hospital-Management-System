<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\PasswordResetOtpMail;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Display the account recovery page.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Display the OTP verification page.
     */
    public function showVerifyOtp(): View
    {
        return view('auth.verify-otp');
    }

    /**
     * Display the reset password page.
     */
    public function showResetPassword(): View
    {
        // Make sure the OTP was verified first.
        if (!session('password_reset_verified')) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Please verify your OTP first.',
                ]);
        }

        return view('auth.reset-password');
    }

    /**
     * Generate and store a password reset OTP.
     */
    public function sendOtp(Request $request): RedirectResponse
    {
        // 1. Validate the email.
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // 2. Get the email entered by the user.
        $email = $request->input('email');

        // 3. Find the user.
        $user = User::where('email', $email)->first();

        // 4. Do not reveal whether an account exists.
        if (!$user) {
            return back()->with(
                'status',
                'If an account exists for this email, a verification code has been sent.'
            );
        }

        // 5. Store the email in the session.
        session([
            'password_reset_email' => $user->email,
        ]);

        // 6. Generate a secure 6-digit OTP.
        $otp = (string) random_int(100000, 999999);

        // 7. Make the OTP valid for 5 minutes.
        $expiresAt = now()->addMinutes(5);

        // 8. Save OTP information in the database.
        $user->otp_code = $otp;
        $user->otp_expires_at = $expiresAt;
        $user->save();

        // 9. Log the OTP temporarily for development/testing.
        Log::info('Password reset OTP generated.', [
            'email' => $user->email,
            'otp' => $otp,
            'expires_at' => $expiresAt,
        ]);

        // 10. Send the OTP to the user's email.
            Mail::raw(
                "Your MediLink password reset verification code is: {$otp}\n\n"
             . "This code will expire in 5 minutes.\n\n"
            . "If you did not request a password reset, please ignore this email.",
             function ($message) use ($user) {
             $message
            ->to($user->email)
            ->subject('MediLink Password Reset OTP');
    }
);

        // 11. Redirect immediately to the OTP verification page.
        return redirect()->route('verify-otp');
    }

    /**
     * Verify the password reset OTP.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        // 1. Make sure all six OTP boxes contain one digit.
        $request->validate([
            'otp' => ['required', 'array', 'size:6'],
            'otp.*' => ['required', 'digits:1'],
        ]);

        // 2. Get the email stored during the forgot-password step.
        $email = session('password_reset_email');

        // 3. Make sure the password reset session exists.
        if (!$email) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'otp' => 'Your password reset session has expired. Please start again.',
                ]);
        }

        // 4. Find the user.
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'otp' => 'Unable to verify your request.',
                ]);
        }

        // 5. Check whether the OTP has expired.
        if (
            !$user->otp_expires_at ||
            now()->greaterThan($user->otp_expires_at)
        ) {
            return back()->withErrors([
                'otp' => 'Your OTP has expired. Please request a new one.',
            ]);
        }

        // 6. Combine the six OTP boxes into one OTP.
        $enteredOtp = implode('', $request->otp);

        // 7. Compare the entered OTP with the database OTP.
        if ((string) $user->otp_code !== $enteredOtp) {
            return back()->withErrors([
                'otp' => 'Incorrect or invalid OTP. Please try again.',
            ]);
        }

        // 8. OTP is correct.
        // Mark the password reset process as verified.
        session([
            'password_reset_verified' => true,
        ]);

        // 9. Delete the OTP so it cannot be reused.
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // 10. Redirect to the reset password page with a confirmation message.
        return redirect()
            ->route('reset.password')
            ->with('status', 'OTP verified successfully. You can now reset your password.');
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        // 1. Make sure the OTP was successfully verified first.
        if (!session('password_reset_verified')) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'password' => 'Please verify your OTP first.',
                ]);
        }

        // 2. Validate the new password.
        // The "confirmed" rule makes sure password_confirmation
        // is exactly the same as password.
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 3. Get the email stored during the password reset process.
        $email = session('password_reset_email');

        // 4. Make sure the email still exists in the session.
        if (!$email) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'password' => 'Your password reset session has expired. Please start again.',
                ]);
        }

        // 5. Find the user.
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'password' => 'Unable to reset your password.',
                ]);
        }

        // 6. Hash the new password before saving it.
        $user->password = Hash::make($request->password);

        // 7. Save the new password in the database.
        $user->save();

        // 8. Clear the password reset session.
        session()->forget([
            'password_reset_email',
            'password_reset_verified',
        ]);

        // 9. Redirect the user to the login page.
        return redirect()
            ->route('login')
            ->with(
                'status',
                'Your password has been reset successfully. You can now log in.'
            );
    }
}