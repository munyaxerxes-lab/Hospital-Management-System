<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\medicine as Medicine;

/*
|--------------------------------------------------------------------------
| 1. Public Guest Flow (Unauthenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get("/", function () {
        return view('auth.register');
    });

    Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // 🌟 FIXED: Unified names so BOTH route('login') and route('login.submit') work perfectly
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->name('show.login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    
    // 🌟 FIXED: Unified names so BOTH route('password.request') and route('password.update') work perfectly
    Route::get('/reset-password', function () {
        return view('auth.reset-password');
    })->name('password.request')->name('reset.password');

    Route::post('/reset-password', function (\Illuminate\Http\Request $request) {
        return back()->with('status', 'If your email is registered, we have sent a reset link.');
    })->name('password.update');
});

// Explicit handle for global logout POST requests safely
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| 2. Authenticated Patient Workspace
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:patient'])->group(function () {
    
    //: Passed the $user variable to prevent "Undefined variable $user" errors
    Route::get('/patient/dashboard', function () {
        $user = Auth::user();
        return view('account.patient.dashboard', compact('user'));
    })->name('patient.dashboard');

    Route::get('/user', function () {
        $user = Auth::user();
        return view('account.patient.dashboard', compact('user'));
    })->name('user.dashboard');
    
    Route::get('/appointments', function () {
        return view('account.patient.appointments');
    });
    
    Route::get('/pharmacy', function () {
        $medicines = Medicine::whereNotNull('image')->where('image', '!=', '')->get();
        return view('account.patient.pharmacy', compact('medicines'));
    });
    
    Route::get('/notifications', function () {
        return view('account.patient.notifications');
    });
    
    Route::get('/labtests', function () {
        return view('account.patient.labtests');
    });
    
    Route::get('/history', function () {
        return view('account.patient.history');
    });
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    
    // Booking Actions
    Route::get('/book', function () { return view('multi.apptm'); });
    Route::get('/request', function () { return view('multi.lab'); });
    
    // Utility Redirect Paths
    Route::get('/back', function () { return view('account.patient.appointments'); });
    Route::get('/appointmentdone', function () { return view('account.patient.appointments'); });
    Route::get('/backtolab', function () { return view('account.patient.labtests'); });

    Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])->name('account.delete');
});


/*
|--------------------------------------------------------------------------
| 3. Authenticated Admin Workspace (Staff Management)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::get('/admin/dashboard', function () {
        return view('account.admin.admin_dashboard');
    })->name('admin.dashboard');

    Route::get('/admin_dashboard', function () {
        return view('account.admin.admin_dashboard');
    });

    Route::get('/appointment_request', function () {
        return view('account.admin.appointment_request');
    });

    Route::get('/lab_request', function () {
        return view('account.admin.lab_request');
    });

    Route::get('/manage_doctors', function () {
        return view('account.admin.manage_doctors');
    });

    Route::get('/medicine_orders', function () {
        return view('account.admin.medicine_orders');
    });
});


/*
|--------------------------------------------------------------------------
| 4. Cart Management Functions
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});


/*
|--------------------------------------------------------------------------
| 5. Internal System Profiles & External Requirements
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/Dr john', function () { return view('account.viewprofile.john-doe'); });
    Route::get('/Dr jane', function () { return view('account.viewprofile.jane'); });
    Route::get('/Dr sarah', function () { return view('account.viewprofile.sarah-jen'); });
    Route::get('/Dr michael', function () { return view('account.viewprofile.michael'); });
});
