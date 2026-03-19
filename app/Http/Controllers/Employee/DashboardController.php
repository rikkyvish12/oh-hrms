<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the employee dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $employeeDetail = $user->employeeDetail;
        
        // Get today's attendance
        $todayAttendance = Attendance::where('employee_id', $user->id)
            ->where('date', today())
            ->first();
        
        // Get pending leave requests
        $pendingLeaves = Leave::where('employee_id', $user->id)
            ->where('status', 'pending')
            ->count();
        
        // Get recent attendances
        $recentAttendances = Attendance::where('employee_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();
        
        // Get leave balance
        $leaveBalance = $employeeDetail ? $employeeDetail->leave_balance : 0;
        
        return view('employee.dashboard', compact(
            'user',
            'employeeDetail',
            'todayAttendance',
            'pendingLeaves',
            'recentAttendances',
            'leaveBalance'
        ));
    }
}
