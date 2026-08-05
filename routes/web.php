<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;





/*user's routes======*/

Route::get('/', function () {
    return view('account.patient.dashboard');
});
Route::get('/appointments', function () {
    return view('account.patient.appointments');
});
use App\Models\medicine as Medicine;

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