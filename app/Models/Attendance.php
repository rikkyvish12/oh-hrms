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
            $punchIn = \Carbon\Carbon::createFromFormat('H:i:s', $this->punch_in);
            $punchOut = \Carbon\Carbon::createFromFormat('H:i:s', $this->punch_out);
            return $punchOut->diffInHours($punchIn);
        }
        return 0;
    }

    /**
     * Check if worked 9 hours
     */
    public function hasCompletedWorkday()
    {
        return $this->worked_hours >= 9;
    }
}
