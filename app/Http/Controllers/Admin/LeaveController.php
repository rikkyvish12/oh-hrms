<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of all leave requests.
     */
    public function index()
    {
        $leaves = Leave::with('employee.employeeDetail', 'approver')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.leaves.index', compact('leaves'));
    }

    /**
     * Display the specified leave request.
     */
    public function show(Leave $leave)
    {
        $leave->load('employee.employeeDetail');
        return view('admin.leaves.show', compact('leave'));
    }

    /**
     * Approve the specified leave request.
     */
    public function approve(Leave $leave)
    {
        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
        ]);

        // Deduct leave balance
        $employee = $leave->employee;
        $days = $leave->duration;
        
        if ($employee->employeeDetail) {
            $currentBalance = $employee->employeeDetail->leave_balance;
            $employee->employeeDetail()->update([
                'leave_balance' => max(0, $currentBalance - $days),
            ]);
        }

        return back()->with('success', 'Leave approved successfully.');
    }

    /**
     * Reject the specified leave request.
     */
    public function reject(Leave $leave)
    {
        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Leave rejected successfully.');
    }

    /**
     * Get pending leave requests
     */
    public function pending()
    {
        $leaves = Leave::with('employee.employeeDetail')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.leaves.pending', compact('leaves'));
    }

    /**
     * Get approved leave requests
     */
    public function approved()
    {
        $leaves = Leave::with('employee.employeeDetail', 'approver')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.leaves.approved', compact('leaves'));
    }

    /**
     * Get rejected leave requests
     */
    public function rejected()
    {
        $leaves = Leave::with('employee.employeeDetail', 'approver')
            ->where('status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.leaves.rejected', compact('leaves'));
    }
}
