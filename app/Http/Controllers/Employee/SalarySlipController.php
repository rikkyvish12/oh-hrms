<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SalarySlip;

class SalarySlipController extends Controller
{
    /**
     * Display a listing of the employee's salary slips.
     */
    public function index()
    {
        $salarySlips = SalarySlip::where('employee_id', Auth::id())
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(10);
        
        return view('employee.salary-slips.index', compact('salarySlips'));
    }

    /**
     * Display salary slip details.
     */
    public function show($id)
    {
        $salarySlip = SalarySlip::where('employee_id', Auth::id())
            ->with('employee.employeeDetail')
            ->findOrFail($id);
        
        return view('employee.salary-slips.show', compact('salarySlip'));
    }

    /**
     * Preview salary slip.
     */
    public function preview($id)
    {
        $salarySlip = SalarySlip::where('employee_id', Auth::id())
            ->with('employee.employeeDetail')
            ->findOrFail($id);
        
        return view('employee.salary-slips.preview', compact('salarySlip'));
    }

    /**
     * Download salary slip.
     */
    public function download($id)
    {
        $salarySlip = SalarySlip::where('employee_id', Auth::id())
            ->with('employee.employeeDetail')
            ->findOrFail($id);
        
        // Use the admin PDF template for consistency
        return view('admin.salary-slips.pdf', compact('salarySlip'));
    }
}
