<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'punch_in',
        'punch_out',
        'ip_address',
    ];

    protected $casts = [
        'date' => 'date',
        'punch_in' => 'datetime:H:i:s',
        'punch_out' => 'datetime:H:i:s',
    ];

    /**
     * Get the employee
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Calculate worked hours
     */
    public function getWorkedHoursAttribute()
    {
        if ($this->punch_in && $this->punch_out) {
            try {
                // Parse times - they may include date components or be time-only
                $punchIn = \Carbon\Carbon::parse($this->punch_in);
                $punchOut = \Carbon\Carbon::parse($this->punch_out);
                
                // Ensure both times are on the same date for proper calculation
                // Use the attendance date as the reference
                if ($this->date) {
                    $referenceDate = \Carbon\Carbon::parse($this->date);
                    $punchIn = $referenceDate->copy()->setTime(
                        $punchIn->hour,
                        $punchIn->minute,
                        $punchIn->second
                    );
                    $punchOut = $referenceDate->copy()->setTime(
                        $punchOut->hour,
                        $punchOut->minute,
                        $punchOut->second
                    );
                }
                
                // If punch_out is before punch_in, it might be a次日 scenario
                // but for standard workdays, we assume same day
                if ($punchOut < $punchIn) {
                    // Keep punch_out on the same date as punch_in
                    $punchOut = $punchIn->copy()->setTime(
                        $punchOut->hour,
                        $punchOut->minute,
                        $punchOut->second
                    );
                }
                
                // Calculate absolute difference in minutes and convert to hours
                $diffInMinutes = abs($punchIn->diffInMinutes($punchOut));
                return $diffInMinutes / 60;
            } catch (\Exception $e) {
                // If parsing fails, return 0
                return 0;
            }
        }
        return 0;
    }

    /**
     * Get attendance status based on working hours
     * >= 8 hours: Full Day (Present)
     * >= 4 hours and < 8 hours: Half Day
     * < 4 hours: Absent
     */
    public function getAttendanceStatusAttribute()
    {
        $workedHours = $this->worked_hours;
        
        if ($workedHours >= 8) {
            return 'Full Day';
        } elseif ($workedHours >= 4) {
            return 'Half Day';
        } else {
            return 'Absent';
        }
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute()
    {
        switch ($this->attendance_status) {
            case 'Full Day':
                return 'green';
            case 'Half Day':
                return 'yellow';
            case 'Absent':
                return 'red';
            default:
                return 'gray';
        }
    }

    /**
     * Check if worked 8 hours or more (Full Day)
     */
    public function isFullDay()
    {
        return $this->worked_hours >= 8;
    }

    /**
     * Check if worked 4-8 hours (Half Day)
     */
    public function isHalfDay()
    {
        return $this->worked_hours >= 4 && $this->worked_hours < 8;
    }

    /**
     * Check if worked less than 4 hours (Absent)
     */
    public function isAbsent()
    {
        return $this->worked_hours < 4;
    }
}
