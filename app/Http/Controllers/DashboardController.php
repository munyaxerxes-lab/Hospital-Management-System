<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Option A: If you want to show the currently logged-in user's profile info
        $currentUser = Auth::user(); 

        // Pass both variables to the dashboard view
        return view('account.patient.dashboard', compact('currentUser'));
    }
}
