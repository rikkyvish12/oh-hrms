<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
        'employee_id',
        'phone',
        'address',
        'date_of_birth',
        'date_of_joining',
        'leave_balance',
        'basic_salary',
        'hra',
        'special_allowance',
        'medical_allowance',
        'travel_allowance',
        'provident_fund',
        'professional_tax',
        'overtime_rate_per_hour',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_joining' => 'date',
        'leave_balance' => 'decimal:2',
        'basic_salary' => 'decimal:2',
        'hra' => 'decimal:2',
        'special_allowance' => 'decimal:2',
        'medical_allowance' => 'decimal:2',
        'travel_allowance' => 'decimal:2',
        'provident_fund' => 'decimal:2',
        'professional_tax' => 'decimal:2',
        'overtime_rate_per_hour' => 'decimal:2',
    ];

    /**
     * Get the user that owns the employee detail
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
