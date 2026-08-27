<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use App\Models\doctor_schedule;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\lab_test;
use App\Models\LabRequest;
use App\Models\lab_request_items;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

echo "=====================================================\n";
echo "   COMPREHENSIVE ADMIN SYSTEM FUNCTIONALITY TEST     \n";
echo "=====================================================\n\n";

// 1. Ensure Roles & Admin User Exist
$adminRole = Role::firstOrCreate(['name' => 'admin'], ['name' => 'admin']);
$patientRole = Role::firstOrCreate(['name' => 'patient'], ['name' => 'patient']);

$adminUser = User::where('email', 'admin@medilink.com')->first();
if (!$adminUser) {
    $adminUser = User::create([
        'name' => 'Hospital Admin',
        'email' => 'admin@medilink.com',
        'password' => Hash::make('password'),
        'role_id' => $adminRole->id,
    ]);
}
Auth::login($adminUser);
echo "✔ [AUTH] Admin authenticated: " . Auth::user()->name . " (" . Auth::user()->email . ")\n";

// 2. Test Doctor Management
echo "\n--- TESTING DOCTOR MANAGEMENT ---\n";
$docCtrl = app(\App\Http\Controllers\DoctorController::class);

$randomUsername = 'test_dr_' . rand(1000, 9999);
$req = Request::create('/admin/doctors', 'POST', [
    'doctor_name' => 'Dr. Test Specialist',
    'specialty' => 'Cardiology',
    'qualification' => 'MBBS, MD Cardiology',
    'years_of_experience' => 12,
    'consultation_fee' => 15000,
    'username' => $randomUsername,
    'status' => 'active',
]);
$docCtrl->store($req);
$createdDoc = Doctor::where('username', $randomUsername)->first();
assert($createdDoc !== null, "Doctor creation failed");
echo "✔ [DOCTOR CREATE] Doctor created: {$createdDoc->doctor_name} (ID: {$createdDoc->id})\n";

// Update doctor
$updateReq = Request::create("/admin/doctors/{$createdDoc->id}", 'PUT', [
    'doctor_name' => 'Dr. Test Specialist Updated',
    'specialty' => 'Neurosurgery',
    'qualification' => 'MBBS, MD, PhD',
    'years_of_experience' => 15,
    'consultation_fee' => 20000,
    'username' => $randomUsername,
    'status' => 'active',
]);
$docCtrl->update($updateReq, $createdDoc);
$createdDoc->refresh();
assert($createdDoc->specialty === 'Neurosurgery', "Doctor update failed");
echo "✔ [DOCTOR UPDATE] Doctor updated specialty to: {$createdDoc->specialty}\n";

// Toggle doctor status
$docCtrl->toggleStatus($createdDoc->id);
$createdDoc->refresh();
assert($createdDoc->status === 'inactive', "Doctor toggle status failed");
echo "✔ [DOCTOR TOGGLE] Doctor status toggled to: {$createdDoc->status}\n";

// 3. Test Appointment / Schedule Management
echo "\n--- TESTING APPOINTMENT MANAGEMENT ---\n";
$apptCtrl = app(\App\Http\Controllers\AppointmentController::class);

$apptReq = Request::create('/admin/appointments', 'POST', [
    'doctor_id' => $createdDoc->id,
    'price' => 20000,
    'status' => 'available',
    'reason' => 'Neurosurgical Consultation',
    'date' => date('Y-m-d', strtotime('+2 days')),
    'available_hours' => ['09:00 AM', '09:30 AM', '10:00 AM'],
]);
$apptCtrl->store($apptReq);
$createdSchedule = doctor_schedule::where('doctor_id', $createdDoc->id)->latest()->first();
assert($createdSchedule !== null, "Appointment creation failed");
echo "✔ [APPOINTMENT CREATE] Schedule created (ID: {$createdSchedule->id}) for Doctor ID {$createdDoc->id}\n";

// Toggle appointment status
$apptCtrl->toggleStatus($createdSchedule->id);
$createdSchedule->refresh();
assert($createdSchedule->status === 'unavailable', "Appointment toggle failed");
echo "✔ [APPOINTMENT TOGGLE] Schedule status toggled to: {$createdSchedule->status}\n";

// 4. Test Pharmacy & Medicine Orders
echo "\n--- TESTING PHARMACY & MEDICINE ORDERS ---\n";
$medCtrl = app(\App\Http\Controllers\MedicineController::class);

$medReq = Request::create('/admin/medicines', 'POST', [
    'name' => 'Ciprofloxacin 500mg Test',
    'type' => 'Tablets',
    'stock' => 50,
    'expiry_date' => date('Y-m-d', strtotime('+1 year')),
    'price' => 3500,
    'description' => 'Antibiotic medication',
]);
$medCtrl->store($medReq);
$createdMed = Medicine::where('name', 'Ciprofloxacin 500mg Test')->latest()->first();
assert($createdMed !== null, "Medicine creation failed");
echo "✔ [MEDICINE CREATE] Created: {$createdMed->name} (Stock: {$createdMed->stock})\n";

// Update medicine
$medUpdateReq = Request::create("/admin/medicines/{$createdMed->id}", 'PUT', [
    'name' => 'Ciprofloxacin 500mg Test',
    'type' => 'Tablets',
    'stock' => 45,
    'expiry_date' => date('Y-m-d', strtotime('+1 year')),
    'price' => 3800,
    'description' => 'Antibiotic medication - updated',
    'status' => '1',
]);
$medCtrl->update($medUpdateReq, $createdMed);
$createdMed->refresh();
assert($createdMed->price == 3800, "Medicine update failed");
echo "✔ [MEDICINE UPDATE] Updated price to: {$createdMed->price} FCFA\n";

// Test Cart Checkout flow
$cartCtrl = app(\App\Http\Controllers\CartController::class);
Cart::where('user_id', $adminUser->id)->delete();
Cart::create([
    'user_id' => $adminUser->id,
    'medicine_id' => $createdMed->id,
    'quantity' => 2,
]);
$checkoutReq = Request::create('/cart/checkout', 'POST', [
    'shipping_address' => 'Ward 4B, MediLink Hospital',
    'payment_method' => 'cash_on_delivery',
]);
$cartCtrl->checkout($checkoutReq);
$createdOrder = Order::where('user_id', $adminUser->id)->latest()->first();
assert($createdOrder !== null, "Order checkout failed");
assert($createdOrder->items->count() === 1, "Order items missing");
$createdMed->refresh();
assert($createdMed->stock === 43, "Stock decrement failed: expected 43, got {$createdMed->stock}");
echo "✔ [CART CHECKOUT] Order #{$createdOrder->order_number} created, stock decremented to {$createdMed->stock}\n";

// Admin Update Order Status
$orderStatusReq = Request::create("/admin/orders/{$createdOrder->id}/status", 'PATCH', [
    'status' => 'delivered'
]);
$medCtrl->updateOrderStatus($orderStatusReq, $createdOrder->id);
$createdOrder->refresh();
assert($createdOrder->status === 'delivered', "Order status update failed");
echo "✔ [ORDER STATUS] Order marked as: {$createdOrder->status} (Delivered at: {$createdOrder->delivered_at})\n";

// 5. Test Laboratory & Diagnostic Requests
echo "\n--- TESTING LABORATORY MANAGEMENT & RESULT UPLOADS ---\n";
$labCtrl = app(\App\Http\Controllers\LabTestController::class);

$labTestReq = Request::create('/admin/lab-tests', 'POST', [
    'name' => 'Liver Function Panel Test',
    'category' => 'Biochemistry',
    'price' => 12500,
    'description' => 'Comprehensive liver health check',
    'preparation' => '10 hours fasting required',
]);
$labCtrl->store($labTestReq);
$createdLabTest = lab_test::where('name', 'Liver Function Panel Test')->latest()->first();
assert($createdLabTest !== null, "Lab test creation failed");
echo "✔ [LAB TEST CREATE] Created test: {$createdLabTest->name} ({$createdLabTest->price} FCFA)\n";

// Update lab test
$labTestUpdateReq = Request::create("/admin/lab-tests/{$createdLabTest->id}", 'PUT', [
    'name' => 'Liver Function Panel Test (LFT)',
    'category' => 'Biochemistry',
    'price' => 14000,
    'description' => 'Comprehensive liver panel updated',
    'preparation' => '12 hours fasting required',
    'status' => '1',
]);
$labCtrl->update($labTestUpdateReq, $createdLabTest);
$createdLabTest->refresh();
assert($createdLabTest->price == 14000, "Lab test update failed");
echo "✔ [LAB TEST UPDATE] Updated test price to: {$createdLabTest->price} FCFA\n";

// Patient Lab Request Booking
$patientLabReq = Request::create('/patient/lab-request', 'POST', [
    'test_ids' => [$createdLabTest->id],
    'address' => 'Room 204, MediLink Clinic',
    'scheduled_date' => date('Y-m-d', strtotime('+1 day')),
    'scheduled_time' => '10:30 AM',
    'notes' => 'Patient has routine follow-up',
    'payment_method' => 'momo',
]);
$labCtrl->storePatientRequest($patientLabReq);
$createdLabReq = LabRequest::where('user_id', $adminUser->id)->latest()->first();
assert($createdLabReq !== null, "Patient lab booking failed");
assert($createdLabReq->items->count() === 1, "Lab request items missing");
echo "✔ [LAB REQUEST BOOKING] Lab Request #{$createdLabReq->request_number} recorded in DB (Status: {$createdLabReq->status})\n";

// Admin Uploads Diagnostic Result Document (PDF / Word / Image)
Storage::fake('public');
$fakePdf = UploadedFile::fake()->create('diagnostic_report.pdf', 500, 'application/pdf');
$uploadResultReq = Request::create("/admin/lab-requests/{$createdLabReq->id}/upload-result", 'POST', [
    'result_file' => $fakePdf,
    'result_notes' => 'All transaminase parameters within normal reference ranges.',
]);
$uploadResultReq->files->set('result_file', $fakePdf);
$labCtrl->uploadResult($uploadResultReq, $createdLabReq->id);
$createdLabReq->refresh();

assert($createdLabReq->status === 'delivered', "Lab request status should be delivered after result upload");
assert($createdLabReq->result_file_type === 'pdf', "Result file type detection failed");
assert(!empty($createdLabReq->result_document), "Result document path not set");
echo "✔ [LAB RESULT UPLOAD] Uploaded result: {$createdLabReq->result_file_name} ({$createdLabReq->result_file_type}), status automatically updated to: {$createdLabReq->status}\n";

// Clean up test data
$labCtrl->deleteRequest($createdLabReq->id);
$labCtrl->destroy($createdLabTest);
$medCtrl->deleteOrder($createdOrder->id);
$medCtrl->destroy($createdMed);
$apptCtrl->destroy($createdSchedule->id);
$docCtrl->destroy($createdDoc);

echo "\n✔ [CLEANUP] All temporary test records safely purged.\n";
echo "\n=====================================================\n";
echo "    ALL ADMIN COMMANDS & WORKFLOWS VERIFIED 100%!    \n";
echo "=====================================================\n";
