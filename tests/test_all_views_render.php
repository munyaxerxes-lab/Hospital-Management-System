<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\lab_test;
use App\Models\doctor_schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

echo "=====================================================\n";
echo "       ALL ADMIN & PATIENT VIEWS RENDER TEST        \n";
echo "=====================================================\n\n";

$adminRole = Role::firstOrCreate(['name' => 'admin']);
$adminUser = User::firstOrCreate(['email' => 'admin@medilink.com'], [
    'name' => 'Hospital Admin',
    'password' => bcrypt('password'),
    'role_id' => $adminRole->id,
]);
Auth::login($adminUser);

$routesToTest = [
    '/admin/dashboard' => 'Admin Dashboard',
    '/appointment_request' => 'Admin Appointments Index',
    '/admin/appointments/create' => 'Admin Create Appointment',
    '/manage_doctors' => 'Admin Manage Doctors',
    '/medicine_orders' => 'Admin Medicine Orders (Inventory tab)',
    '/medicine_orders?tab=orders' => 'Admin Medicine Orders (Orders tab)',
    '/lab_request' => 'Admin Lab Request (Catalog tab)',
    '/lab_request?tab=requests' => 'Admin Lab Request (Requests tab)',
    '/admin/profile/settings' => 'Admin Profile Settings',
];

$firstDoctor = Doctor::first();
if ($firstDoctor) {
    $routesToTest["/admin/doctors/{$firstDoctor->id}/edit"] = "Admin Edit Doctor";
}

$firstSchedule = doctor_schedule::first();
if ($firstSchedule) {
    $routesToTest["/admin/appointments/{$firstSchedule->id}/edit"] = "Admin Edit Appointment";
}

$firstMed = Medicine::first();
if ($firstMed) {
    $routesToTest["/admin/medicines/{$firstMed->id}/edit"] = "Admin Edit Medicine";
}

$firstLabTest = lab_test::first();
if ($firstLabTest) {
    $routesToTest["/admin/lab-tests/{$firstLabTest->id}/edit"] = "Admin Edit Lab Test";
}

$passed = 0;
$failed = 0;

foreach ($routesToTest as $uri => $label) {
    try {
        $req = Request::create($uri, 'GET');
        $response = $app->handle($req);
        $status = $response->getStatusCode();
        if ($status >= 200 && $status < 400) {
            echo "✔ [PASS - {$status}] {$label} ({$uri})\n";
            $passed++;
        } else {
            echo "✖ [FAIL - {$status}] {$label} ({$uri})\n";
            $failed++;
        }
    } catch (\Throwable $e) {
        echo "✖ [EXCEPTION] {$label} ({$uri}): " . $e->getMessage() . "\n";
        $failed++;
    }
}

echo "\n-----------------------------------------------------\n";
echo "Render Results: {$passed} passed, {$failed} failed.\n";
echo "=====================================================\n";
