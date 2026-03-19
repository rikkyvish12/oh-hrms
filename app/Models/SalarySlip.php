<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalarySlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'total_working_days',
        'present_days',
        'absent_days',
        'paid_leaves',
        'overtime_hours',
        'basic_salary',
        'hra',
        'special_allowance',
        'medical_allowance',
        'travel_allowance',
        'overtime_pay',
        'other_earnings',
        'gross_salary',
        'provident_fund',
        'professional_tax',
        'tax_deducted',
        'other_deductions',
        'total_deductions',
        'net_salary',
        'remarks',
        'is_generated',
        'generated_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'total_working_days' => 'integer',
        'present_days' => 'integer',
        'absent_days' => 'integer',
        'paid_leaves' => 'integer',
        'overtime_hours' => 'decimal:2',
        'basic_salary' => 'decimal:2',
        'hra' => 'decimal:2',
        'special_allowance' => 'decimal:2',
        'medical_allowance' => 'decimal:2',
        'travel_allowance' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'other_earnings' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'provident_fund' => 'decimal:2',
        'professional_tax' => 'decimal:2',
        'tax_deducted' => 'decimal:2',
        'other_deductions' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'is_generated' => 'boolean',
        'generated_at' => 'datetime',
    ];

    /**
     * Get the employee who owns the salary slip
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Calculate gross salary
     */
    public function calculateGrossSalary()
    {
        $this->gross_salary = $this->basic_salary 
            + $this->hra 
            + $this->special_allowance 
            + $this->medical_allowance 
            + $this->travel_allowance 
            + $this->overtime_pay 
            + $this->other_earnings;
        
        return $this->gross_salary;
    }

    /**
     * Calculate total deductions
     */
    public function calculateTotalDeductions()
    {
        $this->total_deductions = $this->provident_fund 
            + $this->professional_tax 
            + $this->tax_deducted 
            + $this->other_deductions;
        
        return $this->total_deductions;
    }

    /**
     * Calculate net salary
     */
    public function calculateNetSalary()
    {
        $this->calculateGrossSalary();
        $this->calculateTotalDeductions();
        $this->net_salary = $this->gross_salary - $this->total_deductions;
        
        return $this->net_salary;
    }

    /**
     * Generate salary slip from attendance data
     */
    public static function generateFromAttendance($employeeId, $month, $year)
    {
        $employee = User::find($employeeId);
        if (!$employee || !$employee->employeeDetail) {
            return null;
        }

        $employeeDetail = $employee->employeeDetail;
        
        // Validate salary data exists
        if (!$employeeDetail->basic_salary) {
            throw new \Exception('Employee salary details not configured. Please add salary information to the employee.');
        }
        
        // Get attendance data for the month
        $startDate = \Carbon\Carbon::createFromDate((int)$year, (int)$month, 1)->startOfMonth();
        $endDate = (clone $startDate)->endOfMonth();

        $attendances = Attendance::where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // Calculate working days and present days
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
        
        $totalWorkingDays = $totalDaysInMonth - $sundays; // Exclude Sundays
        $absentDays = max(0, $totalWorkingDays - $presentDays);

        // Calculate overtime hours
        $overtimeHours = 0;
        foreach ($attendances as $attendance) {
            if ($attendance->punch_in && $attendance->punch_out) {
                $workedHours = $attendance->worked_hours;
                if ($workedHours > 9) {
                    $overtimeHours += ($workedHours - 9);
                }
            }
        }

        // Calculate salary components (handle null values)
        $basicSalary = $employeeDetail->basic_salary ?? 0;
        $hra = $employeeDetail->hra ?? 0;
        $specialAllowance = $employeeDetail->special_allowance ?? 0;
        $medicalAllowance = $employeeDetail->medical_allowance ?? 0;
        $travelAllowance = $employeeDetail->travel_allowance ?? 0;
        $overtimeRate = $employeeDetail->overtime_rate_per_hour ?? 0;
        $providentFund = $employeeDetail->provident_fund ?? 0;
        $professionalTax = $employeeDetail->professional_tax ?? 0;

        // Pro-rate based on attendance
        $divisionFactor = max(1, $totalWorkingDays);
        $actualBasic = ($basicSalary / $divisionFactor) * $presentDays;
        $actualHRA = ($hra / $divisionFactor) * $presentDays;
        $actualSpecialAllowance = ($specialAllowance / $divisionFactor) * $presentDays;
        $actualMedicalAllowance = ($medicalAllowance / $divisionFactor) * $presentDays;
        $actualTravelAllowance = ($travelAllowance / $divisionFactor) * $presentDays;
        $overtimePay = $overtimeHours * $overtimeRate;

        // Create or update salary slip
        $salarySlip = SalarySlip::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'month' => (int)$month,
                'year' => (int)$year,
            ],
            [
                'total_working_days' => $totalWorkingDays,
                'present_days' => $presentDays,
                'absent_days' => $absentDays,
                'paid_leaves' => 0,
                'overtime_hours' => round($overtimeHours, 2),
                'basic_salary' => round($actualBasic, 2),
                'hra' => round($actualHRA, 2),
                'special_allowance' => round($actualSpecialAllowance, 2),
                'medical_allowance' => round($actualMedicalAllowance, 2),
                'travel_allowance' => round($actualTravelAllowance, 2),
                'overtime_pay' => round($overtimePay, 2),
                'other_earnings' => 0,
                'provident_fund' => round($providentFund, 2),
                'professional_tax' => round($professionalTax, 2),
                'tax_deducted' => 0,
                'other_deductions' => 0,
            ]
        );

        $salarySlip->calculateNetSalary();
        $salarySlip->is_generated = true;
        $salarySlip->generated_at = now();
        $salarySlip->save();

        return $salarySlip;
    }

    /**
     * Scope to get salary slips by month and year
     */
    public function scopeForMonthYear($query, $month, $year)
    {
        return $query->where('month', $month)
            ->where('year', $year);
    }

    /**
     * Get formatted month-year
     */
    public function getFormattedMonthYearAttribute()
    {
        try {
            return \Carbon\Carbon::createFromDate((int)$this->year, (int)$this->month, 1)->format('F Y');
        } catch (\Exception $e) {
            return "Month {$this->month} {$this->year}";
        }
    }
}
