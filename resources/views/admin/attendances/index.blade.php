@extends('layouts.admin')

@section('title', 'Employee Attendance')
@section('page-title', 'Attendance Tracking')

@section('content')
<!-- Back Button and Employee Info -->
<div class="mb-6">
    <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Employees
    </a>
    
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-2xl font-bold text-blue-600">{{ substr($employee->name, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $employee->name }}</h2>
                    <p class="text-gray-600">{{ $employee->employeeDetail->employee_id ?? 'N/A' }} • {{ $employee->employeeDetail->role->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Type Selector -->
<div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 mb-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <button onclick="changeView('daily')" 
                class="px-4 py-2 rounded-lg font-medium transition-colors {{ $viewType === 'daily' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Daily
            </button>
            <button onclick="changeView('monthly')" 
                class="px-4 py-2 rounded-lg font-medium transition-colors {{ $viewType === 'monthly' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Monthly
            </button>
            <button onclick="changeView('yearly')" 
                class="px-4 py-2 rounded-lg font-medium transition-colors {{ $viewType === 'yearly' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Yearly
            </button>
        </div>
        
        <!-- Date Filters -->
        <form id="filterForm" method="GET" class="flex gap-2 items-center flex-wrap">
            <input type="hidden" name="view" value="{{ $viewType }}">
            
            @if($viewType === 'daily')
                <input type="date" name="date" value="{{ request('date', today()) }}" 
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    onchange="document.getElementById('filterForm').submit()">
            @endif
            
            @if($viewType === 'monthly' || $viewType === 'yearly')
                <select name="year" onchange="document.getElementById('filterForm').submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            @endif
            
            @if($viewType === 'monthly')
                <select name="month" onchange="document.getElementById('filterForm').submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $monthName)
                        <option value="{{ $index + 1 }}" {{ ($index + 1) == $month ? 'selected' : '' }}>
                            {{ $monthName }}
                        </option>
                    @endforeach
                </select>
            @endif
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Days</p>
                <p class="text-3xl font-bold text-gray-900">{{ $summary['total_days'] }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Full Days</p>
                <p class="text-3xl font-bold text-green-600">{{ $summary['present_days'] }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2">≥ 8 hours</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Half Days</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $summary['half_days'] }}</p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2">4-8 hours</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Absent Days</p>
                <p class="text-3xl font-bold text-red-600">{{ $summary['absent_days'] }}</p>
            </div>
            <div class="p-3 bg-red-100 rounded-lg">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2">< 4 hours</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Avg Hours/Day</p>
                <p class="text-3xl font-bold text-purple-600">{{ $summary['average_hours_per_day'] }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2">{{ $summary['total_working_hours'] }} total hrs</p>
    </div>
</div>

<!-- Attendance Table -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Attendance Details</h2>
        <p class="text-gray-600 mt-1">Detailed record of punch in/out times</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Punch In</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Punch Out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Working Hours</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($attendances as $attendance)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                        <br>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($attendance->date)->format('l') }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($attendance->punch_in)
                            <span class="font-medium">{{ \Carbon\Carbon::parse($attendance->punch_in)->format('h:i A') }}</span>
                            <br>
                            <span class="text-xs text-gray-500">{{ $attendance->punch_in }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($attendance->punch_out)
                            <span class="font-medium">{{ \Carbon\Carbon::parse($attendance->punch_out)->format('h:i A') }}</span>
                            <br>
                            <span class="text-xs text-gray-500">{{ $attendance->punch_out }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($attendance->punch_in && $attendance->punch_out)
                            <span class="font-medium">{{ number_format($attendance->worked_hours, 2) }} hrs</span>
                            <br>
                            <span class="text-xs text-gray-500">{{ floor($attendance->worked_hours) }}h {{ round(($attendance->worked_hours % 1) * 60) }}m</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'Full Day' => 'bg-green-100 text-green-800',
                                'Half Day' => 'bg-yellow-100 text-yellow-800',
                                'Absent' => 'bg-red-100 text-red-800'
                            ];
                            $statusColor = $statusColors[$attendance->attendance_status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                            {{ $attendance->attendance_status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $attendance->ip_address ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">No attendance records found</h3>
                            <p class="text-gray-500">No attendance data available for the selected period</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
function changeView(viewType) {
    const url = new URL(window.location.href);
    url.searchParams.set('view', viewType);
    
    // Reset date params when changing view
    if (viewType !== 'daily') {
        url.searchParams.delete('date');
    }
    
    window.location.href = url.toString();
}
</script>
@endsection
