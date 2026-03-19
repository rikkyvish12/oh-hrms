<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Leave;
use App\Models\EmployeeDetail;

class LeaveController extends Controller
{
    /**
     * Display a listing of the employee's leave requests.
     */
    public function index()
    {
        $leaves = Leave::where('employee_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('employee.leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new leave request.
     */
    public function create()
    {
        $employeeDetail = Auth::user()->employeeDetail;
        $leaveBalance = $employeeDetail ? $employeeDetail->leave_balance : 0;
        return view('employee.leaves.create', compact('leaveBalance'));
    }

    /**
     * Store a newly created leave request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $employee = Auth::user();
        $employeeDetail = $employee->employeeDetail;
        
        // Calculate leave duration
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $days = $endDate->diffInDays($startDate) + 1;
        
        // Check leave balance
        if ($employeeDetail) {
            if ($employeeDetail->leave_balance < $days) {
                return back()->with('error', 'Insufficient leave balance. You have ' . $employeeDetail->leave_balance . ' days left.');
            }
        }

        Leave::create([
            'employee_id' => $employee->id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('employee.leaves.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Display the specified leave request.
     */
    public function show(Leave $leave)
    {
        // Ensure the leave belongs to the authenticated employee
        if ($leave->employee_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }
        
        return view('employee.leaves.show', compact('leave'));
    }

    /**
     * Cancel a leave request.
     */
    public function destroy(Leave $leave)
    {
        // Ensure the leave belongs to the authenticated employee
        if ($leave->employee_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }
        
        // Only allow cancellation of pending leaves
        if ($leave->status !== 'pending') {
            return back()->with('error', 'You can only cancel pending leave requests.');
        }
        
        $leave->delete();
        
        return redirect()->route('employee.leaves.index')
            ->with('success', 'Leave request cancelled successfully.');
    }
}
