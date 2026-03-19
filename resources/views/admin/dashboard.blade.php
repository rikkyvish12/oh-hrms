@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<!-- Stats Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Employees Card -->
    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Employees</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalEmployees }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    <span>+12% from last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Admins Card -->
    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">System Admins</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAdmins }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-blue-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>All accounts active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Leaves Card -->
    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pending Leaves</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pendingLeaves }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-yellow-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Requires attention</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance Card -->
    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Today's Attendance</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $todayAttendance }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>On time today</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Analytics Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Leave Statistics Chart -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Leave Statistics</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Approved</span>
                    <span class="text-sm font-medium text-green-600">{{ $approvedLeaves }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $approvedLeaves > 0 ? ($approvedLeaves / ($approvedLeaves + $pendingLeaves + $rejectedLeaves) * 100) : 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Pending</span>
                    <span class="text-sm font-medium text-yellow-600">{{ $pendingLeaves }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $pendingLeaves > 0 ? ($pendingLeaves / ($approvedLeaves + $pendingLeaves + $rejectedLeaves) * 100) : 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Rejected</span>
                    <span class="text-sm font-medium text-red-600">{{ $rejectedLeaves }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ $rejectedLeaves > 0 ? ($rejectedLeaves / ($approvedLeaves + $pendingLeaves + $rejectedLeaves) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Summary -->
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-lg border border-blue-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Summary</h3>
        <div class="space-y-4">
            <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $totalEmployees }} Active Employees</p>
                    <p class="text-xs text-gray-500">Across all departments</p>
                </div>
            </div>
            <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $pendingLeaves }} Leave Requests</p>
                    <p class="text-xs text-gray-500">Awaiting approval</p>
                </div>
            </div>
            <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                <div class="p-2 bg-green-100 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $todayAttendance }} Check-ins</p>
                    <p class="text-xs text-gray-500">Today's attendance</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Quick Actions</h2>
        <p class="text-gray-600 mt-1">Manage your HR system efficiently</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.employees.index') }}" class="group block p-4 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-100 hover:border-blue-200 transition-all duration-200 transform hover:-translate-y-0.5 btn-hover">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-500 rounded-lg group-hover:bg-blue-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-gray-900 group-hover:text-blue-700">Manage Employees</h3>
                        <p class="text-sm text-gray-500">View and edit employee records</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.roles.index') }}" class="group block p-4 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-100 hover:border-purple-200 transition-all duration-200 transform hover:-translate-y-0.5 btn-hover">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-500 rounded-lg group-hover:bg-purple-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-5 0v2a2 2 0 002 2h2M19 19a2 2 0 01-2 2h-2a2 2 0 01-2-2m2-4a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-gray-900 group-hover:text-purple-700">Manage Roles</h3>
                        <p class="text-sm text-gray-500">Configure user permissions</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.leaves.index') }}" class="group block p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg border border-yellow-100 hover:border-yellow-200 transition-all duration-200 transform hover:-translate-y-0.5 btn-hover">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-500 rounded-lg group-hover:bg-yellow-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-gray-900 group-hover:text-yellow-700">Manage Leaves</h3>
                        <p class="text-sm text-gray-500">Review leave applications</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.letters.index') }}" class="group block p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg border border-indigo-100 hover:border-indigo-200 transition-all duration-200 transform hover:-translate-y-0.5 btn-hover">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-500 rounded-lg group-hover:bg-indigo-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-gray-900 group-hover:text-indigo-700">Manage Letters</h3>
                        <p class="text-sm text-gray-500">Generate official documents</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.ip-restrictions.index') }}" class="group block p-4 bg-red-50 hover:bg-red-100 rounded-lg border border-red-100 hover:border-red-200 transition-all duration-200 transform hover:-translate-y-0.5 btn-hover">
                <div class="flex items-center">
                    <div class="p-3 bg-red-500 rounded-lg group-hover:bg-red-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-gray-900 group-hover:text-red-700">IP Restrictions</h3>
                        <p class="text-sm text-gray-500">Control system access</p>
                    </div>
                </div>
            </a>

            <a href="#" class="group block p-4 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-100 hover:border-gray-200 transition-all duration-200 transform hover:-translate-y-0.5 btn-hover">
                <div class="flex items-center">
                    <div class="p-3 bg-gray-500 rounded-lg group-hover:bg-gray-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.545-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.545-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.545.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.545.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-gray-900 group-hover:text-gray-700">Settings</h3>
                        <p class="text-sm text-gray-500">System configuration</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection