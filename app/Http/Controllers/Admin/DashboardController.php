<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;
use App\Models\Attendance;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $totalEmployees = User::where('user_type', 'employee')->count();
        $totalAdmins = User::where('user_type', 'admin')->count();
        
        $pendingLeaves = Leave::where('status', 'pending')->count();
        $approvedLeaves = Leave::where('status', 'approved')->count();
        $rejectedLeaves = Leave::where('status', 'rejected')->count();
        
        $todayAttendance = Attendance::where('date', today())->count();
        
        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalAdmins',
            'pendingLeaves',
            'approvedLeaves',
            'rejectedLeaves',
            'todayAttendance'
        ));
    }
}
