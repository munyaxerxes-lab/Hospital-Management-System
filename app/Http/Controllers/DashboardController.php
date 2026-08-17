<?php


    namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
       public function patientDashboard()
            {
                $user = Auth::user(); // Uses the Facade you already imported at the top

                $patient = $user->patient;

                $appointmentsCount = $patient?->appointments()->count() ?? 0;
                $medicinesCount = $patient?->orders()->count() ?? 0;
                $labTestsCount = $patient?->lab_test()->count() ?? 0;

                // We pass the name directly into the compact function
                $name = $user->name;

                return view('account.patient.dashboard', compact(
                    'appointmentsCount',
                    'medicinesCount',
                    'labTestsCount',
                    'name' // 👈 This makes $name available in your view
                ));
            }

}

