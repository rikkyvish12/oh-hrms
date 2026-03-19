<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->string('month');
            $table->integer('year');
            $table->integer('total_working_days')->default(26);
            $table->integer('present_days')->default(0);
            $table->integer('absent_days')->default(0);
            $table->integer('paid_leaves')->default(0);
            $table->decimal('overtime_hours', 8, 2)->default(0);
            
            // Earnings
            $table->decimal('basic_salary', 10, 2)->default(0);
            $table->decimal('hra', 10, 2)->default(0);
            $table->decimal('special_allowance', 10, 2)->default(0);
            $table->decimal('medical_allowance', 10, 2)->default(0);
            $table->decimal('travel_allowance', 10, 2)->default(0);
            $table->decimal('overtime_pay', 10, 2)->default(0);
            $table->decimal('other_earnings', 10, 2)->default(0);
            $table->decimal('gross_salary', 10, 2)->default(0);
            
            // Deductions
            $table->decimal('provident_fund', 10, 2)->default(0);
            $table->decimal('professional_tax', 10, 2)->default(0);
            $table->decimal('tax_deducted', 10, 2)->default(0);
            $table->decimal('other_deductions', 10, 2)->default(0);
            $table->decimal('total_deductions', 10, 2)->default(0);
            
            // Net salary
            $table->decimal('net_salary', 10, 2)->default(0);
            
            $table->text('remarks')->nullable();
            $table->boolean('is_generated')->default(false);
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_slips');
    }
};
