@extends('layouts.admin')

@section('title', 'View Salary Slip')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
            <i class="fas fa-file-invoice-dollar mr-3 text-blue-600"></i>
            Salary Slip Details
        </h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.salary-slips.download', $salarySlip->id) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center" target="_blank">
                <i class="fas fa-download mr-2"></i> Download PDF
            </a>
            <a href="{{ route('admin.salary-slips.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Salary Slip Preview -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                @include('admin.salary-slips._slip_preview', ['salarySlip' => $salarySlip])
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Employee Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user mr-2 text-blue-600"></i>
                    Employee Information
                </h2>
                <dl class="space-y-3">
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500">Name:</dt>
                        <dd class="text-sm text-gray-900">{{ $salarySlip->employee->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500">Employee ID:</dt>
                        <dd class="text-sm text-gray-900">{{ $salarySlip->employee->employeeDetail->employee_id ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500">Designation:</dt>
                        <dd class="text-sm text-gray-900">{{ $salarySlip->employee->employeeDetail->role->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500">Date of Joining:</dt>
                        <dd class="text-sm text-gray-900">{{ $salarySlip->employee->employeeDetail->date_of_joining?->format('d M Y') ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Attendance Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-calendar-check mr-2 text-purple-600"></i>
                    Attendance Summary
                </h2>
                <div class="text-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $salarySlip->formatted_month_year }}</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                        <i class="fas fa-calendar text-blue-600 text-xl mb-2"></i>
                        <p class="text-2xl font-bold text-gray-900">{{ $salarySlip->total_working_days }}</p>
                        <p class="text-xs text-gray-600 mt-1">Working Days</p>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                        <i class="fas fa-check-circle text-green-600 text-xl mb-2"></i>
                        <p class="text-2xl font-bold text-gray-900">{{ $salarySlip->present_days }}</p>
                        <p class="text-xs text-gray-600 mt-1">Present Days</p>
                    </div>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                        <i class="fas fa-times-circle text-red-600 text-xl mb-2"></i>
                        <p class="text-2xl font-bold text-gray-900">{{ $salarySlip->absent_days }}</p>
                        <p class="text-xs text-gray-600 mt-1">Absent Days</p>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                        <i class="fas fa-clock text-yellow-600 text-xl mb-2"></i>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($salarySlip->overtime_hours, 1) }}</p>
                        <p class="text-xs text-gray-600 mt-1">Overtime Hours</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
