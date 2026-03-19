<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'template_id',
        'content',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    /**
     * Get the employee
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get the template used to generate this letter
     */
    public function template()
    {
        return $this->belongsTo(LetterTemplate::class);
    }
}
