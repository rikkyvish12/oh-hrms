<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display attendance page for a specific employee.
     */
    public function index($employeeId, Request $request)
    {
        $employee = User::where('user_type', 'employee')
            ->with('employeeDetail.role')
            ->findOrFail($employeeId);

        // Get filter parameters
        $viewType = $request->get('view', 'monthly'); // daily, monthly, yearly
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        // Get attendances based on view type
        $attendances = $this->getAttendances($employeeId, $viewType, $year, $month);
        
        // Calculate summary
        $summary = $this->calculateSummary($attendances, $viewType, $year, $month);
        
        return view('admin.attendances.index', compact(
            'employee', 
            'attendances', 
            'viewType', 
            'year', 
            'month',
            'summary'
        ));
    }

    /**
     * Get attendances based on view type.
     */
    private function getAttendances($employeeId, $viewType, $year, $month)
    {
        $query = Attendance::where('employee_id', $employeeId);

        if ($viewType === 'daily') {
            $date = request()->get('date', today());
            $query->where('date', $date);
        } elseif ($viewType === 'monthly') {
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        } elseif ($viewType === 'yearly') {
            $query->whereYear('date', $year);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    /**
     * Calculate attendance summary.
     */
    private function calculateSummary($attendances, $viewType, $year, $month)
    {
        $totalDays = $attendances->count();
        $presentDays = 0;
        $halfDays = 0;
        $absentDays = 0;
        $totalWorkingHours = 0;

        foreach ($attendances as $attendance) {
            $workedHours = $attendance->worked_hours;
            $totalWorkingHours += $workedHours;

            if ($workedHours >= 8) {
                $presentDays++;
            } elseif ($workedHours >= 4) {
                $halfDays++;
            } else {
                $absentDays++;
            }
        }

        return [
            'total_days' => $totalDays,
            'present_days' => $presentDays,
            'half_days' => $halfDays,
            'absent_days' => $absentDays,
            'total_working_hours' => round($totalWorkingHours, 2),
            'average_hours_per_day' => $totalDays > 0 ? round($totalWorkingHours / $totalDays, 2) : 0,
        ];
    }

    /**
     * Get attendance data via AJAX.
     */
    public function getData(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'view' => 'required|in:daily,monthly,yearly',
            'year' => 'required|numeric|min:2000|max:' . (now()->year + 1),
        ]);

        $employeeId = $request->employee_id;
        $viewType = $request->view;
        $year = (int)$request->year;
        $month = $request->has('month') ? (int)$request->month : now()->month;

        $attendances = $this->getAttendances($employeeId, $viewType, $year, $month);
        $summary = $this->calculateSummary($attendances, $viewType, $year, $month);

        return response()->json([
            'success' => true,
            'data' => $attendances,
            'summary' => $summary,
        ]);
    }
}
