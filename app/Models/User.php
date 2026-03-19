<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'is_password_set',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_password_set' => 'boolean',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if user is employee
     */
    public function isEmployee(): bool
    {
        return $this->user_type === 'employee';
    }

    /**
     * Get employee details
     */
    public function employeeDetail()
    {
        return $this->hasOne(EmployeeDetail::class);
    }

    /**
     * Get attendances
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    /**
     * Get leaves
     */
    public function leaves()
    {
        return $this->hasMany(Leave::class, 'employee_id');
    }

    /**
     * Get letters
     */
    public function letters()
    {
        return $this->hasMany(Letter::class, 'employee_id');
    }

    /**
     * Get approved leaves
     */
    public function approvedLeaves()
    {
        return $this->hasMany(Leave::class, 'approved_by');
    }
}
