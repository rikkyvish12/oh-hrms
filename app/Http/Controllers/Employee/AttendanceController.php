<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the employee's attendance.
     */
    public function index()
    {
        $attendances = Attendance::where('employee_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);
        return view('employee.attendances.index', compact('attendances'));
    }

    /**
     * Punch in for the day.
     */
    public function punchIn(Request $request)
    {
        $user = Auth::user();
        $today = today();
        
        // Check if already punched in today
        $existingAttendance = Attendance::where('employee_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($existingAttendance && $existingAttendance->punch_in) {
            return back()->with('error', 'You have already punched in today.');
        }

        // Create or update attendance record
        Attendance::updateOrCreate(
            [
                'employee_id' => $user->id,
                'date' => $today,
            ],
            [
                'punch_in' => Carbon::now()->toTimeString(),
                'ip_address' => $request->ip(),
            ]
        );

        return back()->with('success', 'Punched in successfully at ' . Carbon::now()->format('H:i:s'));
    }

    /**
     * Punch out for the day.
     */
    public function punchOut(Request $request)
    {
        $user = Auth::user();
        $today = today();
        
        // Find today's attendance
        $attendance = Attendance::where('employee_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->punch_in) {
            return back()->with('error', 'You need to punch in first before punching out.');
        }

        if ($attendance->punch_out) {
            return back()->with('error', 'You have already punched out today.');
        }

        // Update attendance with punch out time
        $attendance->update([
            'punch_out' => Carbon::now()->toTimeString(),
        ]);

        // Calculate worked hours
        $punchIn = Carbon::createFromFormat('H:i:s', $attendance->punch_in);
        $punchOut = Carbon::createFromFormat('H:i:s', $attendance->punch_out);
        $workedHours = $punchOut->diffInHours($punchIn);

        return back()->with('success', 'Punched out successfully at ' . Carbon::now()->format('H:i:s') . ". You worked for {$workedHours} hours.");
    }

    /**
     * Display attendance calendar.
     */
    public function calendar()
    {
        $user = Auth::user();
        $month = request()->get('month', now()->month);
        $year = request()->get('year', now()->year);
        
        $attendances = Attendance::where('employee_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->keyBy('date');

        return view('employee.attendances.calendar', compact('attendances', 'month', 'year'));
    }

    /**
     * Get attendance summary.
     */
    public function summary()
    {
        $user = Auth::user();
        
        $totalDays = Attendance::where('employee_id', $user->id)->count();
        $presentDays = Attendance::where('employee_id', $user->id)
            ->whereNotNull('punch_in')
            ->count();
        $absentDays = now()->day - $presentDays;
        
        $completedWorkdays = Attendance::where('employee_id', $user->id)
            ->get()
            ->filter(function ($attendance) {
                if ($attendance->punch_in && $attendance->punch_out) {
                    $punchIn = Carbon::createFromFormat('H:i:s', $attendance->punch_in);
                    $punchOut = Carbon::createFromFormat('H:i:s', $attendance->punch_out);
                    return $punchOut->diffInHours($punchIn) >= 9;
                }
                return false;
            })->count();

        return view('employee.attendances.summary', compact('totalDays', 'presentDays', 'absentDays', 'completedWorkdays'));
    }
}
