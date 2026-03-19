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
        Schema::table('employee_details', function (Blueprint $table) {
            $table->decimal('basic_salary', 10, 2)->nullable()->after('leave_balance');
            $table->decimal('hra', 10, 2)->nullable()->after('basic_salary');
            $table->decimal('special_allowance', 10, 2)->nullable()->after('hra');
            $table->decimal('medical_allowance', 10, 2)->nullable()->after('special_allowance');
            $table->decimal('travel_allowance', 10, 2)->nullable()->after('medical_allowance');
            $table->decimal('provident_fund', 10, 2)->default(0)->after('travel_allowance');
            $table->decimal('professional_tax', 10, 2)->default(0)->after('provident_fund');
            $table->decimal('overtime_rate_per_hour', 10, 2)->default(0)->after('professional_tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_details', function (Blueprint $table) {
            $table->dropColumn([
                'basic_salary',
                'hra',
                'special_allowance',
                'medical_allowance',
                'travel_allowance',
                'provident_fund',
                'professional_tax',
                'overtime_rate_per_hour',
            ]);
        });
    }
};
