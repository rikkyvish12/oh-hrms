@extends('layouts.employee')

@section('title', 'Request Leave')
@section('page-title', 'Request Leave')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Request Leave</h1>
        <p class="text-gray-600">Submit a new leave request</p>
    </div>

    <!-- Leave Balance Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Available Leave Balance</p>
                <p class="text-2xl font-bold text-gray-900">{{ $leaveBalance }} days</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Leave Details</h2>
        </div>
        
        @if(session('error'))
            <div class="m-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        
        <form action="{{ route('employee.leaves.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Leave Type Field -->
                <div>
                    <label for="leave_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Leave Type <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="leave_type" 
                        name="leave_type" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('leave_type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                        required>
                        <option value="">Select Type</option>
                        <option value="sick">Sick Leave</option>
                        <option value="casual">Casual Leave</option>
                        <option value="annual">Annual Leave</option>
                        <option value="other">Other</option>
                    </select>
                    @error('leave_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="start_date" 
                            name="start_date" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('start_date') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            required>
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="end_date" 
                            name="end_date" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('end_date') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            required>
                        @error('end_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Reason Field -->
                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="reason" 
                        name="reason" 
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('reason') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                        placeholder="Please provide a reason for your leave request"
                        required></textarea>
                    @error('reason')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('employee.leaves.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection