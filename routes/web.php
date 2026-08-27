<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\MedicineController;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Global Fallback & Entry Handler (Bypasses Guest Group Loops)
|--------------------------------------------------------------------------
*/
Route::get("/", function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role && $user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('patient.dashboard');
    }
    return view('auth.register');
});

/*
|--------------------------------------------------------------------------
| 1. Public Guest Flow (Unauthenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('show.register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

    // Naming references for login forms
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login-page', [AuthController::class, 'showLogin'])->name('show.login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    
    // Naming references for forgot/reset flows
    Route::get('/reset-password', function () { return view('auth.reset-password'); })->name('password.request');
    Route::get('/forgot-password', function () { return view('auth.reset-password'); })->name('reset.password');

    Route::post('/reset-password', function (Request $request) {
        return back()->with('status', 'If your email is registered, we have sent a reset link.');
    })->name('password.update');

    Route::get('/verify-otp', [RegisteredUserController::class, 'showVerifyOtp'])->name('register.verify-otp');
    Route::post('/verify-otp', [RegisteredUserController::class, 'verifyOtp'])->name('register.verify-otp.submit');
    Route::post('/resend-otp', [RegisteredUserController::class, 'resendOtp'])->name('register.resend-otp');
});

/*
|--------------------------------------------------------------------------
| 2. Global Route: Secure Logout Handling
|--------------------------------------------------------------------------
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
        $medicines = Medicine::where('status', true)->latest()->get();
        $categories = Medicine::where('status', true)->select('type')->distinct()->pluck('type')->filter()->values();
        $userId = auth()->id();
        $cartCount = $userId ? \App\Models\cart::where('user_id', $userId)->sum('quantity') : 0;
        return view('account.patient.pharmacy', compact('medicines', 'categories', 'cartCount'));
    })->name('patient.pharmacy');
    
    Route::get('/notifications', function () {
        return view('account.patient.notifications');
    });
    
    Route::get('/labtests', function () {
        $lab_tests = \App\Models\lab_test::where('status', true)->latest()->get();
        return view('account.patient.labtests', compact('lab_tests'));
    })->name('patient.labtests');
    
    Route::post('/patient/lab-request', [LabTestController::class, 'storePatientRequest'])
        ->name('patient.lab_request.store');

    Route::get('/patient/lab-results/{id}/download', [LabTestController::class, 'downloadResult'])
        ->name('patient.lab_results.download');
    
    Route::get('/history', function () {
        $user = Auth::user();
        $patient = $user ? \App\Models\Patient::where('user_id', $user->id)->first() : null;

        // Lab requests for this patient (with items eager-loaded)
        $labRequests = $patient
            ? \App\Models\LabRequest::with(['items.test'])
                ->where('patient_id', $patient->id)
                ->latest()
                ->get()
            : collect();

        // Pharmacy orders for this patient (with items & medicines)
        $orders = $patient
            ? \App\Models\Order::with(['items.medicine'])
                ->where('patient_id', $patient->id)
                ->latest()
                ->get()
            : collect();

        // Appointments for this patient (with doctor & schedule)
        $appointments = $patient
            ? \App\Models\appointments::with(['doctor.user', 'doctor_schedule'])
                ->where('patient_id', $patient->id)
                ->latest()
                ->get()
            : collect();

        return view('account.patient.history', compact('labRequests', 'orders', 'appointments'));
    })->name('patient.history');
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    
    // Booking Actions
    Route::get('/book', function () { return view('multi.apptm'); });
    Route::get('/request', function () { return view('multi.lab'); });
    
    // Utility Redirect Paths
    Route::get('/back', function () { return view('account.patient.appointments'); });
    Route::get('/appointmentdone', function () { return view('account.patient.appointments'); });
    Route::get('/backtolab', function () { return view('account.patient.labtests'); });

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
        $stats = [
            'appointments' => \App\Models\doctor_schedule::count(),
            'available_slots' => \App\Models\doctor_schedule::where('status', 'available')->count(),
            'booked_slots' => \App\Models\doctor_schedule::where('status', 'booked')->count(),
            'lab_tests' => \Illuminate\Support\Facades\DB::table('lab_tests')->count(),
            'medicines' => \App\Models\Medicine::count(),
            'total_doctors' => \App\Models\Doctor::count(),
            'active_doctors' => \App\Models\Doctor::where('status', 'active')->count(),
        ];

        $recentSchedules = \App\Models\doctor_schedule::with('doctor')->latest()->take(5)->get();
        $recentDoctors = \App\Models\Doctor::latest()->take(4)->get();

        return view('account.admin.admin_dashboard', compact('stats', 'recentSchedules', 'recentDoctors'));
    })->name('admin.dashboard');

    Route::get('/admin_dashboard', function () {
        return redirect()->route('admin.dashboard');
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

    /*================== ADMIN DOCTOR MANAGEMENT ==================*/
    Route::get('/manage_doctors', [DoctorController::class, 'index'])
        ->name('admin.doctors.index');

    Route::post('/admin/doctors', [DoctorController::class, 'store'])
        ->name('admin.doctors.store');

    Route::get('/admin/doctors/{doctor}/edit', [DoctorController::class, 'edit'])
        ->name('admin.doctors.edit');

    Route::put('/admin/doctors/{doctor}', [DoctorController::class, 'update'])
        ->name('admin.doctors.update');

    Route::patch('/admin/doctors/{id}/toggle-status', [DoctorController::class, 'toggleStatus'])
        ->name('admin.doctors.toggleStatus');

    Route::delete('/admin/doctors/{doctor}', [DoctorController::class, 'destroy'])
        ->name('admin.doctors.delete');

    /*================== ADMIN MEDICINE MANAGEMENT ==================*/
    Route::get('/medicine_orders', [MedicineController::class, 'index'])
        ->name('admin.medicines.index');

    Route::post('/admin/medicines', [MedicineController::class, 'store'])
        ->name('admin.medicines.store');

    Route::get('/admin/medicines/{medicine}/edit', [MedicineController::class, 'edit'])
        ->name('admin.medicines.edit');

    Route::put('/admin/medicines/{medicine}', [MedicineController::class, 'update'])
        ->name('admin.medicines.update');

    Route::patch('/admin/medicines/{id}/toggle-status', [MedicineController::class, 'toggleStatus'])
        ->name('admin.medicines.toggleStatus');

    Route::delete('/admin/medicines/{medicine}', [MedicineController::class, 'destroy'])
        ->name('admin.medicines.delete');

    // Admin Order Management Actions
    Route::patch('/admin/orders/{id}/status', [MedicineController::class, 'updateOrderStatus'])
        ->name('admin.orders.updateStatus');

    Route::delete('/admin/orders/{id}', [MedicineController::class, 'deleteOrder'])
        ->name('admin.orders.delete');

    /*================== ADMIN LAB TEST MANAGEMENT ==================*/
    Route::get('/lab_request', [LabTestController::class, 'index'])
        ->name('admin.lab_tests.index');

    Route::get('/admin/lab_request', [LabTestController::class, 'index']);

    Route::post('/admin/lab-tests', [LabTestController::class, 'store'])
        ->name('admin.lab_tests.store');

    Route::post('/admin/lab_request', [LabTestController::class, 'store']);

    Route::get('/admin/lab-tests/{lab_test}/edit', [LabTestController::class, 'edit'])
        ->name('admin.lab_tests.edit');

    Route::put('/admin/lab-tests/{lab_test}', [LabTestController::class, 'update'])
        ->name('admin.lab_tests.update');

    Route::patch('/admin/lab-tests/{id}/toggle-status', [LabTestController::class, 'toggleStatus'])
        ->name('admin.lab_tests.toggleStatus');

    Route::delete('/admin/lab-tests/{lab_test}', [LabTestController::class, 'destroy'])
        ->name('admin.lab_tests.delete');

    // Admin Lab Request Fulfillment & Result Upload Actions
    Route::patch('/admin/lab-requests/{id}/status', [LabTestController::class, 'updateRequestStatus'])
        ->name('admin.lab_requests.updateStatus');

    Route::post('/admin/lab-requests/{id}/upload-result', [LabTestController::class, 'uploadResult'])
        ->name('admin.lab_requests.uploadResult');

    Route::get('/admin/lab-requests/{id}/download-result', [LabTestController::class, 'downloadResult'])
        ->name('admin.lab_requests.downloadResult');

    Route::delete('/admin/lab-requests/{id}', [LabTestController::class, 'deleteRequest'])
        ->name('admin.lab_requests.delete');

    /*================== ADMIN PROFILE SETTINGS ==================*/
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
| Global Authenticated User Actions
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])->name('account.delete');
});

/*
|--------------------------------------------------------------------------
| 5. Other Role Dashboards (Protected by Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/doctor/dashboard', function () {
        return view('account.doctor.dashboard');
    })->name('doctor.dashboard');

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

/*
|--------------------------------------------------------------------------
| 6. Cart Management Functions
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

/*
|--------------------------------------------------------------------------
| 7. Internal System Profiles & External Requirements
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/Dr john', function () { return view('account.viewprofile.john-doe'); });
    Route::get('/Dr jane', function () { return view('account.viewprofile.jane'); });
    Route::get('/Dr sarah', function () { return view('account.viewprofile.sarah-jen'); });
    Route::get('/Dr michael', function () { return view('account.viewprofile.michael'); });
});

/*
|--------------------------------------------------------------------------
| 8. Auth Scaffold Routes (OTP & Password Reset Handlers)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
