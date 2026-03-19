@extends('layouts.admin')

@section('title', 'Edit Employee')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
            <i class="fas fa-user-edit mr-3 text-blue-600"></i>
            Edit Employee
        </h1>
        <a href="{{ route('admin.employees.index') }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" 
                           value="{{ $employee->name }}" 
                           required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" 
                           value="{{ $employee->email }}" 
                           required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Phone
                    </label>
                    <input type="text" name="phone" 
                           value="{{ $employee->employeeDetail->phone ?? '' }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Date of Birth
                    </label>
                    <input type="date" name="date_of_birth" 
                           value="{{ $employee->employeeDetail->date_of_birth ? $employee->employeeDetail->date_of_birth->format('Y-m-d') : '' }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Date of Joining -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Date of Joining <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date_of_joining" 
                           value="{{ $employee->employeeDetail->date_of_joining ? $employee->employeeDetail->date_of_joining->format('Y-m-d') : '' }}"
                           required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Role
                    </label>
                    <select name="role_id" 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" 
                                    {{ $employee->employeeDetail->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Leave Balance -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Leave Balance
                    </label>
                    <input type="number" name="leave_balance" 
                           value="{{ $employee->employeeDetail->leave_balance ?? 12 }}"
                           step="0.01"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <!-- Address (Full Width) -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Address
                </label>
                <textarea name="address" 
                          rows="3"
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $employee->employeeDetail->address ?? '' }}</textarea>
            </div>

            <!-- Salary Information Section -->
            <div class="mt-8 border-t pt-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-money-bill-wave mr-2 text-green-600"></i>
                    Salary Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Basic Salary -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Basic Salary (₹)
                        </label>
                        <input type="number" name="basic_salary" 
                               value="{{ $employee->employeeDetail->basic_salary ?? '' }}"
                               step="0.01"
                               placeholder="e.g., 25000.00"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- HRA -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            HRA (₹)
                        </label>
                        <input type="number" name="hra" 
                               value="{{ $employee->employeeDetail->hra ?? '' }}"
                               step="0.01"
                               placeholder="e.g., 10000.00"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Special Allowance -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Special Allowance (₹)
                        </label>
                        <input type="number" name="special_allowance" 
                               value="{{ $employee->employeeDetail->special_allowance ?? '' }}"
                               step="0.01"
                               placeholder="e.g., 5000.00"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Medical Allowance -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Medical Allowance (₹)
                        </label>
                        <input type="number" name="medical_allowance" 
                               value="{{ $employee->employeeDetail->medical_allowance ?? '' }}"
                               step="0.01"
                               placeholder="e.g., 2000.00"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Travel Allowance -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Travel Allowance (₹)
                        </label>
                        <input type="number" name="travel_allowance" 
                               value="{{ $employee->employeeDetail->travel_allowance ?? '' }}"
                               step="0.01"
                               placeholder="e.g., 3000.00"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Provident Fund -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Provident Fund (₹)
                        </label>
                        <input type="number" name="provident_fund" 
                               value="{{ $employee->employeeDetail->provident_fund ?? 0 }}"
                               step="0.01"
                               placeholder="e.g., 1800.00"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Professional Tax -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Professional Tax (₹)
                        </label>
                        <input type="number" name="professional_tax" 
                               value="{{ $employee->employeeDetail->professional_tax ?? 0 }}"
                               step="0.01"
                               placeholder="e.g., 200.00"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Overtime Rate -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Overtime Rate/Hour (₹)
                        </label>
                        <input type="number" name="overtime_rate_per_hour" 
                               value="{{ $employee->employeeDetail->overtime_rate_per_hour ?? 0 }}"
                               step="0.01"
                               placeholder="e.g., 500.00"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 mt-8 pt-6 border-t">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-save mr-2"></i> Update Employee
                </button>
                <a href="{{ route('admin.employees.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection