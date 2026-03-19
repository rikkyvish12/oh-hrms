@extends('layouts.employee')

@section('title', 'Attendance Calendar')
@section('page-title', 'Attendance Calendar')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Attendance Calendar</h1>
            <p class="text-gray-600">View your attendance history in calendar format</p>
        </div>
        <a href="{{ route('employee.dashboard') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>
</div>

<!-- Calendar Card -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">{{ Carbon\Carbon::createFromDate($year, $month)->format('F Y') }}</h2>
            <div class="flex space-x-2">
                <a href="{{ route('employee.attendances.calendar', ['month' => $month - 1, 'year' => $year]) }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <a href="{{ route('employee.attendances.calendar', ['month' => $month + 1, 'year' => $year]) }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <table class="w-full">
            <thead>
                <tr class="text-center">
                    <th class="py-2 px-1 text-xs font-medium text-gray-500 uppercase">Sun</th>
                    <th class="py-2 px-1 text-xs font-medium text-gray-500 uppercase">Mon</th>
                    <th class="py-2 px-1 text-xs font-medium text-gray-500 uppercase">Tue</th>
                    <th class="py-2 px-1 text-xs font-medium text-gray-500 uppercase">Wed</th>
                    <th class="py-2 px-1 text-xs font-medium text-gray-500 uppercase">Thu</th>
                    <th class="py-2 px-1 text-xs font-medium text-gray-500 uppercase">Fri</th>
                    <th class="py-2 px-1 text-xs font-medium text-gray-500 uppercase">Sat</th>
                </tr>
            </thead>
            <tbody>
                @php
                $daysInMonth = Carbon\Carbon::createFromDate($year, $month)->daysInMonth;
                $firstDayOfMonth = Carbon\Carbon::createFromDate($year, $month, 1)->dayOfWeek;
                @endphp
                
                <tr>
                @for($i = 0; $i < $firstDayOfMonth; $i++)
                    <td class="p-1"></td>
                @ endfor
                
                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                    $date = Carbon\Carbon::createFromDate($year, $month, $day);
                    $dateStr = $date->toDateString();
                    $attendance = $attendances->get($dateStr);
                    @endphp
                    
                    @if(($day + $firstDayOfMonth - 1) % 7 == 0 && $day != 1)
                </tr><tr>
                    @endif
                    
                    <td class="p-1 align-top {{ $date->isToday() ? 'bg-emerald-50' : '' }}">
                        <div class="text-center mb-1">
                            <span class="text-sm font-medium {{ $date->isToday() ? 'text-emerald-600' : 'text-gray-700' }}">{{ $day }}</span>
                        </div>
                        <div class="text-xs">
                            @if($attendance)
                                @if($attendance->punch_in)
                                    <div class="text-green-600 truncate">In: {{ $attendance->punch_in }}</div>
                                @endif
                                @if($attendance->punch_out)
                                    <div class="text-red-600 truncate">Out: {{ $attendance->punch_out }}</div>
                                @endif
                            @else
                                <span class="text-gray-400">Absent</span>
                            @endif
                        </div>
                    </td>
                @ endfor
                
                @php
                $remainingCells = 7 - (($daysInMonth + $firstDayOfMonth) % 7);
                if($remainingCells < 7):
                @endphp
                    @for($i = 0; $i < $remainingCells; $i++)
                    <td class="p-1"></td>
                    @ endfor
                @endif
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Legend -->
    <div class="p-4 bg-gray-50 border-t border-gray-200">
        <div class="flex flex-wrap items-center justify-center gap-4 text-sm">
            <div class="flex items-center">
                <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                <span class="text-gray-600">Punched In</span>
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                <span class="text-gray-600">Punched Out</span>
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 bg-gray-300 rounded-full mr-2"></span>
                <span class="text-gray-600">Absent</span>
            </div>
        </div>
    </div>
</div>
@endsection