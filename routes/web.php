<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\medicine as Medicine;


/*================== LANDING PAGE ===========*/

Route::get("/", function () 
{
    return view('auth.register');
});


/*================== DASHBOARD ROUTES ==================*/

Route::middleware('auth')->group(function () {

    Route::get('/patient/dashboard', function () {
        return view('account.patient.dashboard');
    })->name('patient.dashboard');

    Route::get('/doctor/dashboard', function () {
        return view('account.doctor.dashboard');
    })->name('doctor.dashboard');

    Route::get('/admin/dashboard', function () {
        return view('account.admin.admin_dashboard');
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


/*================== REGISTRATION ROUTES ==================*/

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('show.register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');


/*================== LOGIN ROUTES ==================*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('show.login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*================== USER / PATIENT ROUTES ==================*/

Route::middleware('auth')->group(function () {

    Route::get('/user', function () {
        return view('account.patient.dashboard');
    })->name('user.dashboard');

    Route::get('/appointments', function () {
        return view('account.patient.appointments');
    });

    Route::get('/pharmacy', function () {

        $medicines = Medicine::whereNotNull('image')
            ->where('image', '!=', '')
            ->get();

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

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

});


/*================== DOCTOR ROUTES ==================*/

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


/*================== CART MANAGEMENT ROUTES ==================*/

Route::post('/cart', [CartController::class, 'store'])
    ->name('cart.store');

Route::post('/cart/add/{id}', [CartController::class, 'add'])
    ->name('cart.add');

Route::put('/cart/{id}', [CartController::class, 'update'])
    ->name('cart.update');

Route::delete('/cart/{id}', [CartController::class, 'destroy'])
    ->name('cart.destroy');


/*================== AUTH ROUTES ==================*/

require __DIR__.'/auth.php';


/*================== RESET PASSWORD ROUTES ==================*/

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset.password');


/*================== USER DASHBOARD ==================*/

Route::get('/user', function () {

    // Fetch the logged-in user record
    $user = Auth::user();

    // Pass the user data into the dashboard blade template
    return view('account.patient.dashboard', compact('user'));

})->name('user.dashboard');


/*
|--------------------------------------------------------------------------
|                  ADMIN ROUTES
|-------------------------------------------------------------------------
*/


/*================== ADMIN DOCTOR MANAGEMENT ==================*/


/*
|--------------------------------------------------------------------------
| Display Manage Doctors page
|--------------------------------------------------------------------------
*/

Route::get('/manage_doctors', [DoctorController::class, 'index'])
    ->name('admin.doctors.index');


/*
|--------------------------------------------------------------------------
| Create Doctor
|--------------------------------------------------------------------------
*/

Route::post('/admin/doctors', [DoctorController::class, 'store'])
    ->name('admin.doctors.store');


/*
|--------------------------------------------------------------------------
| Edit Doctor
|--------------------------------------------------------------------------
*/

Route::get('/admin/doctors/{doctor}/edit', [DoctorController::class, 'edit'])
    ->name('admin.doctors.edit');


/*
|--------------------------------------------------------------------------
| Update Doctor
|--------------------------------------------------------------------------
*/

Route::put('/admin/doctors/{doctor}', [DoctorController::class, 'update'])
    ->name('admin.doctors.update');


/*
|--------------------------------------------------------------------------
| Activate / Deactivate Doctor
|--------------------------------------------------------------------------
*/

Route::patch('/admin/doctors/{id}/toggle-status', [DoctorController::class, 'toggleStatus'])
    ->name('admin.doctors.toggleStatus');


/*
|--------------------------------------------------------------------------
| Delete Doctor
|--------------------------------------------------------------------------
*/

Route::delete('/admin/doctors/{doctor}', [DoctorController::class, 'destroy'])
    ->name('admin.doctors.delete');


/*================== END ADMIN DOCTOR MANAGEMENT ==================*/



/*================== OTHER ADMIN ROUTES ==================*/

Route::get('/admin_dashboard', function () {
    return view('account.admin.admin_dashboard');
});

Route::get('/appointment_request', function () {
    return view('account.admin.appointment_request');
});

Route::get('/lab_request', function () {
    return view('account.admin.lab_request');
});

Route::get('/medicine_orders', function () {
    return view('account.admin.medicine_orders');
});

Route::get('/logout', function () {
    return view('auth.logout');
});


/*================== VIEW PROFILE ROUTES ==================*/

Route::get('/Dr john', function () {
    return view('account.viewprofile.john-doe');
});

Route::get('/Dr jane', function () {
    return view('account.viewprofile.jane');
});

Route::get('/Dr sarah', function () {
    return view('account.viewprofile.sarah-jen');
});

Route::get('/Dr michael', function () {
    return view('account.viewprofile.michael');
});


/*================== BACK ROUTES ==================*/

Route::get('/back', function () {
    return view('account.patient.appointments');
});

Route::get('/appointmentdone', function () {
    return view('account.patient.appointments');
});

Route::get('/backtolab', function () {
    return view('account.patient.labtests');
});


/*================== BOOK ROUTES ==================*/

Route::get('/book', function () {
    return view('multi.apptm');
});

Route::get('/request', function () {
    return view('multi.lab');
});