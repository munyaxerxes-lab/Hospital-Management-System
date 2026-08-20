<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Route::middleware('guest')->group(function () {
//     Route::get('register', [RegisteredUserController::class, 'create'])
//         ->name('register');
    Route::get('register', [RegisteredUserController::class, 'create'])
      ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('/register/verify-otp', [RegisteredUserController::class, 'showVerifyOtp'])
      ->name('register.verify-otp');

    Route::post('/register/verify-otp', [RegisteredUserController::class, 'verifyOtp'])
      ->name('register.verify-otp.submit');

      Route::post('/register/resend-otp', [RegisteredUserController::class, 'resendOtp'])
    ->name('register.resend-otp');


//     login authenfication route //

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
  ->name('login.submit');


// Login OTP verification route //
Route::get('/login/verify-otp', [AuthenticatedSessionController::class, 'showLoginOtp'])
    ->name('login.verify-otp');

Route::post('/login/verify-otp', [AuthenticatedSessionController::class, 'verifyLoginOtp'])
    ->name('login.verify-otp.submit');

// Resend login OTP route //
Route::post('/login/resend-otp', [AuthenticatedSessionController::class, 'resendOtp'])
    ->name('login.resend-otp');

//    for get password route for email and password recuperation //

     Route::get('forgot-password', [ForgotPasswordController::class, 'create'])
       ->name('password.request');

     Route::post('forgot-password', [ForgotPasswordController::class, 'sendOtp'])
        ->name('password.email');
        
//     Route::get('verify-otp/{verifyotp}', [NewPasswordController::class, 'create'])
//         ->name('verify-otp');
      Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyOtp'])
    ->name('verify-otp');

      Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
    ->name('verify-otp.submit');

      Route::post('/forgot-password/resend-otp', [ForgotPasswordController::class, 'resendOtp'])
    ->name('resend-otp');

//     Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
//         ->name('password.reset');

     Route::get('reset-password', [ForgotPasswordController::class, 'showResetPassword'])
    ->name('password.reset');

     Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');

//     Route::post('reset-password', [NewPasswordController::class, 'store'])
//         ->name('password.store');
// });

// Route::middleware('auth')->group(function () {
//     Route::get('verify-email', EmailVerificationPromptController::class)
//         ->name('verification.notice');

//     Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//         ->middleware(['signed', 'throttle:6,1'])
//         ->name('verification.verify');

//     Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//         ->middleware('throttle:6,1')
//         ->name('verification.send');

//     Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
//         ->name('password.confirm');

//     Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

//     Route::put('password', [PasswordController::class, 'update'])->name('password.update');

//     Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
//         ->name('logout');
// });
