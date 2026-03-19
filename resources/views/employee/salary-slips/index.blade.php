@extends('layouts.employee')

@section('title', 'My Salary Slips')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
            <i class="fas fa-file-invoice-dollar mr-3 text-emerald-600"></i>
            My Salary Slips
        </h1>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Salary Slips List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($salarySlips->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month/Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Working Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Present Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Absent Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Overtime Hours</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gross Salary</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deductions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Salary</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($salarySlips as $index => $slip)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $slip->formatted_month_year }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $slip->total_working_days }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $slip->present_days }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $slip->absent_days }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($slip->overtime_hours, 1) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹{{ number_format($slip->gross_salary, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹{{ number_format($slip->total_deductions, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">₹{{ number_format($slip->net_salary, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($slip->is_generated)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Generated
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('employee.salary-slips.show', $slip->id) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('employee.salary-slips.download', $slip->id) }}" 
                                   class="text-green-600 hover:text-green-900" title="Download PDF" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-4">
            {{ $salarySlips->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-file-invoice-dollar text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg mb-2">No salary slips available yet.</p>
            <p class="text-gray-400 text-sm">Your salary slips will appear here once generated by the admin.</p>
        </div>
        @endif
    </div>
</div>
@endsection
