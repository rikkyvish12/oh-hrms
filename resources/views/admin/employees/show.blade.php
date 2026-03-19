@extends('layouts.admin')

@section('title', 'Employee Details')
@section('page-title', 'Employee Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Employee Details</h1>
                <p class="text-gray-600">View employee information</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Employee
                </a>
                <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Employee Details Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden card-hover">
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600">
                <h2 class="text-xl font-semibold text-white">Personal Information</h2>
                <p class="text-blue-100 text-sm mt-1">Basic details</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Full Name</label>
                    <p class="text-gray-800 font-medium">{{ $employee->name }}</p>
                </div>
                
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Email Address</label>
                    <p class="text-gray-800 font-medium">{{ $employee->email }}</p>
                </div>
                
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Phone Number</label>
                    <p class="text-gray-800 font-medium">{{ $employee->employeeDetail->phone ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Address</label>
                    <p class="text-gray-800 font-medium">{{ $employee->employeeDetail->address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Employment Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden card-hover">
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-green-500 to-green-600">
                <h2 class="text-xl font-semibold text-white">Employment Details</h2>
                <p class="text-green-100 text-sm mt-1">Job information</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Employee ID</label>
                    <p class="text-gray-800 font-medium">{{ $employee->employeeDetail->employee_id ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Role/Position</label>
                    <p class="text-gray-800 font-medium">{{ $employee->employeeDetail->role->name ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Date of Joining</label>
                    <p class="text-gray-800 font-medium">{{ $employee->employeeDetail->date_of_joining ? \Carbon\Carbon::parse($employee->employeeDetail->date_of_joining)->format('d M Y') : 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Leave Balance</label>
                    <p class="text-gray-800 font-medium">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $employee->employeeDetail->leave_balance ?? 0 }} days
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden card-hover md:col-span-2">
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-purple-500 to-purple-600">
                <h2 class="text-xl font-semibold text-white">Additional Information</h2>
                <p class="text-purple-100 text-sm mt-1">More details</p>
            </div>
            <div class="p-6">
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Date of Birth</label>
                    <p class="text-gray-800 font-medium">{{ $employee->employeeDetail->date_of_birth ? \Carbon\Carbon::parse($employee->employeeDetail->date_of_birth)->format('d M Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection