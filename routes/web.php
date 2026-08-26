<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabTestController;
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

// Route::get('/appointment', function () {
//     return view('account.doctor.appointment');
// });

// Route::get('/availability', function () {
//     return view('account.doctor.availability');
// });

// Route::get('/consultation', function () {
//     return view('account.doctor.consultation');
// });

// Route::get('/profile', function () {
//     return view('account.doctor.profile');
// });

// Route::get('/home', function () {
//     return view('account.doctor.home');
// });


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



/*================== ADMIN medicines MANAGEMENT ==================*/


/*
|--------------------------------------------------------------------------
| Display Manage medicines page
|--------------------------------------------------------------------------
*/

Route::get('/medicine_orders', [MedicineController::class, 'index'])
    ->name('admin.medicines.index');


/*
|--------------------------------------------------------------------------
| Create Doctor
|--------------------------------------------------------------------------
*/

Route::post('/admin/medicines', [MedicineController::class, 'store'])
    ->name('admin.medicines.store');


/*
|--------------------------------------------------------------------------
| Edit Doctor
|--------------------------------------------------------------------------
*/

Route::get('/admin/medicines/{medicine}/edit', [MedicineController::class, 'edit'])
    ->name('admin.medicines.edit');


/*
|--------------------------------------------------------------------------
| Update Doctor
|--------------------------------------------------------------------------
*/

Route::put('/admin/medicines/{medicine}', [MedicineController::class, 'update'])
    ->name('admin.medicines.update');


/*
|--------------------------------------------------------------------------
| Activate / Deactivate Doctor
|--------------------------------------------------------------------------
*/

Route::patch('/admin/medicines/{id}/toggle-status', [MedicineController::class, 'toggleStatus'])
    ->name('admin.medicines.toggleStatus');


/*
|--------------------------------------------------------------------------
| Delete Doctor
|--------------------------------------------------------------------------
*/

Route::delete('/admin/medicines/{medicine}', [MedicineController::class, 'destroy'])
    ->name('admin.medicines.delete');


/*================== END ADMIN medicine MANAGEMENT ==================*/

Route::get('/admin/lab_request', [LabTestController::class, 'index'])
    ->name('admin.lab_tests.index');

Route::post('/admin/lab_request', [LabTestController::class, 'store'])
    ->name('admin.lab_tests.store');


/*================== OTHER ADMIN ROUTES ==================*/
/*
|--------------------------------------------------------------------------
| Global Fallback Handler (Bypasses Guest Group Loops)
|--------------------------------------------------------------------------
*/
Route::get("/", function () {
    // If a user is already signed in, dynamically throw them past the login wall
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role && $user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('patient.dashboard');
    }
    
    // Otherwise, show unauthenticated visitors your signup view layout
    return view('auth.register');
});

/*
|--------------------------------------------------------------------------
| 1. Public Guest Flow (Unauthenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    //  REMOVED Route::get('/', ...) from here to stop the looping crashes!

    Route::get('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('show.register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register');

    // Naming references for login forms
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login-page', [AuthController::class, 'showLogin'])->name('show.login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    
    // Naming references for forgot/reset flows
    Route::get('/reset-password', function () { return view('auth.reset-password'); })->name('password.request');
    Route::get('/forgot-password', function () { return view('auth.reset-password'); })->name('reset.password');

    Route::post('/reset-password', function (\Illuminate\Http\Request $request) {
        return back()->with('status', 'If your email is registered, we have sent a reset link.');
    })->name('password.update');

    //  FIXED: Mapped 'register.verify-otp' to the GET route and '.submit' to the POST form handler
    Route::get('/verify-otp', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'showVerifyOtp'])->name('register.verify-otp');
    Route::post('/verify-otp', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'verifyOtp'])->name('register.verify-otp.submit');
    Route::post('/resend-otp', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'resendOtp'])->name('register.resend-otp');
});

/*
|--------------------------------------------------------------------------
| 2. Global Route: Secure Logout Handling
|--------------------------------------------------------------------------
| Extracted out of specific workspaces so both Admins and Patients can access it
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. Authenticated Patient Workspace
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:patient'])->group(function () {
    
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

        // Profile Management inside Patient Workspace
        Route::prefix('patient/profile')->group(function () {
        Route::get('/settings', [AuthController::class, 'showSettings'])->name('profile.settings');
        Route::put('/update', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::put('/change-email', [AuthController::class, 'changeEmail'])->name('profile.change-email');
        Route::put('/change-phone', [AuthController::class, 'changePhone'])->name('profile.change-phone');
        Route::put('/update-password', [AuthController::class, 'updatePassword'])->name('profile.update-password');
    });


});

/*
|--------------------------------------------------------------------------
| 4. Authenticated Admin Workspace (Staff Management)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
        

    Route::get('/admin/dashboard', function () {
        return view('account.admin.admin_dashboard');
    })->name('admin.dashboard');

    Route::get('/admin_dashboard', function () {
        return view('account.admin.admin_dashboard');
    });

    /*================== ADMIN APPOINTMENT MANAGEMENT ==================*/
    Route::get('/appointment_request', [AppointmentController::class, 'index'])
        ->name('admin.appointments.index');

    Route::get('/admin/appointments/create', [AppointmentController::class, 'create'])
        ->name('admin.appointments.create');

    Route::post('/admin/appointments', [AppointmentController::class, 'store'])
        ->name('admin.appointments.store');

    Route::get('/admin/appointments/{id}/edit', [AppointmentController::class, 'edit'])
        ->name('admin.appointments.edit');

    Route::put('/admin/appointments/{id}', [AppointmentController::class, 'update'])
        ->name('admin.appointments.update');

    Route::patch('/admin/appointments/{id}/toggle-status', [AppointmentController::class, 'toggleStatus'])
        ->name('admin.appointments.toggleStatus');

    Route::delete('/admin/appointments/{id}', [AppointmentController::class, 'destroy'])
        ->name('admin.appointments.delete');
    /*================== END ADMIN APPOINTMENT MANAGEMENT ==================*/
    /*================== ADMIN LAB TEST MANAGEMENT ==================*/

        Route::get('/lab_request', [LabTestController::class, 'index'])
            ->name('admin.lab_tests.index');

        Route::post('/admin/lab-tests', [LabTestController::class, 'store'])
            ->name('admin.lab_tests.store');

        Route::get('/admin/lab-tests/{lab_test}/edit', [LabTestController::class, 'edit'])
            ->name('admin.lab_tests.edit');

        Route::put('/admin/lab-tests/{lab_test}', [LabTestController::class, 'update'])
            ->name('admin.lab_tests.update');

        Route::patch('/admin/lab-tests/{id}/toggle-status', [LabTestController::class, 'toggleStatus'])
            ->name('admin.lab_tests.toggleStatus');

        Route::delete('/admin/lab-tests/{lab_test}', [LabTestController::class, 'destroy'])
            ->name('admin.lab_tests.delete');

/*================== END ADMIN LAB TEST MANAGEMENT ==================*/

    // Route::get('/lab_request', function () {
    //     return view('account.admin.lab_request');
    // });

    // Route::get('/manage_doctors', function () {
    //     return view('account.admin.manage_doctors');
    // });

    // Route::get('/medicine_orders', function () {
    //     return view('account.admin.medicine_orders');
    // });
        // Profile Management inside Admin Workspace
    Route::prefix('admin/profile')->group(function () {
        Route::get('/settings', [AuthController::class, 'showSettings'])->name('admin.profile.settings');
        Route::put('/update', [AuthController::class, 'updateProfile'])->name('admin.profile.update');
        Route::put('/change-email', [AuthController::class, 'changeEmail'])->name('admin.profile.change-email');
        Route::put('/change-phone', [AuthController::class, 'changePhone'])->name('admin.profile.change-phone');
        Route::put('/update-password', [AuthController::class, 'updatePassword'])->name('admin.profile.update-password');
    });

});

/*
|--------------------------------------------------------------------------
| 5. Cart Management Functions
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
| 6. Internal System Profiles & External Requirements
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/Dr john', function () { return view('account.viewprofile.john-doe'); });
    Route::get('/Dr jane', function () { return view('account.viewprofile.jane'); });
    Route::get('/Dr sarah', function () { return view('account.viewprofile.sarah-jen'); });
    Route::get('/Dr michael', function () { return view('account.viewprofile.michael'); });
});
