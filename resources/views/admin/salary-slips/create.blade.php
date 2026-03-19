@extends('layouts.admin')

@section('title', 'Generate Salary Slip')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
            <i class="fas fa-file-invoice-dollar mr-3 text-blue-600"></i>
            Generate Salary Slip
        </h1>
        <a href="{{ route('admin.salary-slips.index') }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Generate Single Slip -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user mr-2 text-blue-600"></i>
                Generate for Single Employee
            </h2>
            <form action="{{ route('admin.salary-slips.generate') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Employee <span class="text-red-500">*</span>
                    </label>
                    <select name="employee_id" id="employee_id" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Select Employee --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" 
                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }} ({{ $employee->employeeDetail->employee_id ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-2">
                        Month <span class="text-red-500">*</span>
                    </label>
                    <select name="month" id="month" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Select Month --</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    @error('month')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                        Year <span class="text-red-500">*</span>
                    </label>
                    <select name="year" id="year" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Select Year --</option>
                        @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                            <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                    @error('year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center">
                    <i class="fas fa-calculator mr-2"></i> Generate Salary Slip
                </button>
            </form>
        </div>

        <!-- Bulk Generate -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-users mr-2 text-green-600"></i>
                Bulk Generate for All Employees
            </h2>
            <form action="{{ route('admin.salary-slips.bulk-generate') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="bulk_month" class="block text-sm font-medium text-gray-700 mb-2">
                        Month <span class="text-red-500">*</span>
                    </label>
                    <select name="month" id="bulk_month" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Select Month --</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    @error('month')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="bulk_year" class="block text-sm font-medium text-gray-700 mb-2">
                        Year <span class="text-red-500">*</span>
                    </label>
                    <select name="year" id="bulk_year" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Select Year --</option>
                        @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                            <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                    @error('year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-4">
                    <i class="fas fa-info-circle mr-2"></i> 
                    This will generate salary slips for all {{ $employees->count() }} employees.
                </div>

                <button type="submit" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center">
                    <i class="fas fa-bolt mr-2"></i> Generate for All Employees
                </button>
            </form>
        </div>
    </div>

    <!-- Attendance Preview Section -->
    <div class="mt-6" id="attendancePreview" style="display: none;">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-calendar-check mr-2 text-purple-600"></i>
                Attendance Summary Preview
            </h2>
            <div id="attendanceData"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('employee_id').addEventListener('change', function() {
    const employeeId = this.value;
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    
    if (employeeId && month && year) {
        fetchAttendanceSummary(employeeId, month, year);
    }
});

document.getElementById('month').addEventListener('change', function() {
    const employeeId = document.getElementById('employee_id').value;
    const year = document.getElementById('year').value;
    const month = this.value;
    
    if (employeeId && month && year) {
        fetchAttendanceSummary(employeeId, month, year);
    }
});

document.getElementById('year').addEventListener('change', function() {
    const employeeId = document.getElementById('employee_id').value;
    const month = document.getElementById('month').value;
    const year = this.value;
    
    if (employeeId && month && year) {
        fetchAttendanceSummary(employeeId, month, year);
    }
});

function fetchAttendanceSummary(employeeId, month, year) {
    fetch("{{ route('admin.salary-slips.attendance-summary') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ employee_id: employeeId, month: month, year: year })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayAttendanceData(data.data);
        }
    });
}

function displayAttendanceData(data) {
    const html = `
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                <i class="fas fa-calendar text-blue-600 text-2xl mb-2"></i>
                <p class="text-sm text-gray-600 mb-1">Total Working Days</p>
                <p class="text-2xl font-bold text-gray-900">${data.total_working_days}</p>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                <i class="fas fa-check text-green-600 text-2xl mb-2"></i>
                <p class="text-sm text-gray-600 mb-1">Present Days</p>
                <p class="text-2xl font-bold text-gray-900">${data.present_days}</p>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                <i class="fas fa-times text-red-600 text-2xl mb-2"></i>
                <p class="text-sm text-gray-600 mb-1">Absent Days</p>
                <p class="text-2xl font-bold text-gray-900">${data.absent_days}</p>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                <i class="fas fa-clock text-yellow-600 text-2xl mb-2"></i>
                <p class="text-sm text-gray-600 mb-1">Overtime Hours</p>
                <p class="text-2xl font-bold text-gray-900">${data.overtime_hours}</p>
            </div>
        </div>
    `;
    
    document.getElementById('attendanceData').innerHTML = html;
    document.getElementById('attendancePreview').style.display = 'block';
}
</script>
@endpush
@endsection
