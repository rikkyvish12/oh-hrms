<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalarySlip;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalarySlipController extends Controller
{
    /**
     * Display a listing of salary slips.
     */
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        
        $salarySlips = SalarySlip::with('employee.employeeDetail')
            ->where('month', $month)
            ->where('year', $year)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $employees = User::where('user_type', 'employee')
            ->whereHas('employeeDetail')
            ->get();
        
        return view('admin.salary-slips.index', compact('salarySlips', 'month', 'year', 'employees'));
    }

    /**
     * Show the form for generating salary slip.
     */
    public function create()
    {
        $employees = User::where('user_type', 'employee')
            ->whereHas('employeeDetail')
            ->with('employeeDetail')
            ->get();
        
        return view('admin.salary-slips.create', compact('employees'));
    }

    /**
     * Generate salary slip for an employee.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|min:2000|max:' . (now()->year + 1),
        ]);

        try {
            $salarySlip = SalarySlip::generateFromAttendance(
                (int)$request->employee_id,
                (int)$request->month,
                (int)$request->year
            );

            if (!$salarySlip) {
                return back()->with('error', 'Failed to generate salary slip. Employee details not found.');
            }

            return redirect()->route('admin.salary-slips.show', $salarySlip->id)
                ->with('success', 'Salary slip generated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error generating salary slip: ' . $e->getMessage());
        }
    }

    /**
     * Display salary slip details.
     */
    public function show($id)
    {
        $salarySlip = SalarySlip::with(['employee.employeeDetail', 'employee.attendances'])
            ->findOrFail($id);
        
        return view('admin.salary-slips.show', compact('salarySlip'));
    }

    /**
     * Preview salary slip in modal.
     */
    public function preview($id)
    {
        $salarySlip = SalarySlip::with(['employee.employeeDetail'])
            ->findOrFail($id);
        
        return view('admin.salary-slips.preview', compact('salarySlip'));
    }

    /**
     * Download salary slip as PDF.
     */
    public function download($id)
    {
        $salarySlip = SalarySlip::with(['employee.employeeDetail'])
            ->findOrFail($id);
        
        $html = view('admin.salary-slips.pdf', compact('salarySlip'))->render();
        
        // Create a temporary file
        $filename = 'salary_slip_' . $salarySlip->employee->name . '_' . $salarySlip->month . '_' . $salarySlip->year . '.pdf';
        
        // For now, we'll return the HTML view for printing
        // In production, you can use dompdf or snappy packages
        return response()->stream(function () use ($html) {
            echo $html;
        }, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    /**
     * Bulk generate salary slips for all employees.
     */
    public function bulkGenerate(Request $request)
    {
        $request->validate([
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|min:2000|max:' . (now()->year + 1),
        ]);

        $employees = User::where('user_type', 'employee')
            ->whereHas('employeeDetail')
            ->get();

        $generated = 0;
        $failed = 0;
        $errors = [];

        foreach ($employees as $employee) {
            try {
                $result = SalarySlip::generateFromAttendance(
                    $employee->id,
                    (int)$request->month,
                    (int)$request->year
                );
                
                if ($result) {
                    $generated++;
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                $failed++;
                $errors[] = "{$employee->name}: " . $e->getMessage();
            }
        }

        $message = "Salary slips generated: {$generated}, Failed: {$failed}";
        if (count($errors) > 0) {
            $message .= ". Errors: " . implode(", ", array_slice($errors, 0, 3));
        }

        return back()->with('success', $message);
    }

    /**
     * Remove salary slip.
     */
    public function destroy($id)
    {
        $salarySlip = SalarySlip::findOrFail($id);
        $salarySlip->delete();
        
        return back()->with('success', 'Salary slip deleted successfully.');
    }

    /**
     * Get attendance summary for an employee for a given month/year.
     */
    public function getAttendanceSummary(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|min:2000|max:' . (now()->year + 1),
        ]);

        try {
            // Ensure integer values
            $employeeId = (int)$request->employee_id;
            $month = (int)$request->month;
            $year = (int)$request->year;
            
            // Create date safely
            $startDate = new \Carbon\Carbon($year, $month, 1);
            $endDate = (clone $startDate)->endOfMonth();

            $attendances = Attendance::where('employee_id', $employeeId)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();

            $presentDays = $attendances->whereNotNull('punch_in')->count();
            $totalDaysInMonth = $startDate->daysInMonth;
            
            // Count Sundays
            $sundays = 0;
            $currentDate = (clone $startDate);
            while ($currentDate <= $endDate) {
                if ($currentDate->dayOfWeek === 0) {
                    $sundays++;
                }
                $currentDate->addDay();
            }
            
            $totalWorkingDays = $totalDaysInMonth - $sundays;
            $absentDays = max(0, $totalWorkingDays - $presentDays);

            // Calculate overtime
            $overtimeHours = 0;
            foreach ($attendances as $attendance) {
                if ($attendance->punch_in && $attendance->punch_out) {
                    $workedHours = $attendance->worked_hours;
                    if ($workedHours > 9) {
                        $overtimeHours += ($workedHours - 9);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'total_working_days' => $totalWorkingDays,
                    'present_days' => $presentDays,
                    'absent_days' => $absentDays,
                    'overtime_hours' => round($overtimeHours, 2),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error calculating attendance: ' . $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null,
            ], 500);
        }
    }
}
