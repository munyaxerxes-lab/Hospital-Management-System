<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\medicine as Medicine;



/*==================landing page===========*/
Route::get("/", function () 
{
    return view('auth.register');
});

Route::middleware('auth')->group(function () {

    Route::get('/patient/dashboard', function () {
        return view('account.patient.dashboard');
    })->name('patient.dashboard');

    Route::get('/doctor/dashboard', function () {
        return view('account.doctor.dashboard');
    })->name('doctor.dashboard');

    Route::get('/admin/dashboard', function () {
        return view('account.admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/pharmacist/dashboard', function () {
        return view('account.pharmacist.dashboard');
    })->name('pharmacist.dashboard');

    Route::get('/lab/dashboard', function () {
        return view('account.lab.dashboard');
    })->name('account.lab.dashboard');

    Route::get('/delivery/dashboard', function () {
        return view('account.delivery.dashboard');
    })->name('delivery.dashboard');

});



/*============Routes for registration page======================*/

Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

/*============Routes for login page======================*/



Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*user's routes======*/
Route::middleware('auth')->group(function () {

 Route::get('/user', function () {
        return view('account.patient.dashboard');
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

});

/*========= Doctors Routes==========*/
Route::get('/appointment', function () {
    return view('account.doctor.appointment');
});
Route::get('/availability', function () {
    return view('account.doctor.availability');
});
Route::get('/consultation', function () {
    return view('account.doctor.consultation');
});
Route::get('/profile', function () {
    return view('account.doctor.profile');
});
Route::get('/home', function () {
    return view('account.doctor.home');
});

/*===========cart management route=============*/

Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');


require __DIR__.'/auth.php';

/*========= reset-password Routes==========*/

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset.password');






