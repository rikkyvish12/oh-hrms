<div class="salary-slip">
    <!-- Header -->
    <div class="text-center mb-4 pb-3 border-bottom">
        <h2 class="mb-0">{{ config('app.name', 'OHA HRMS') }}</h2>
        <p class="text-muted mb-0">Salary Slip for {{ $salarySlip->formatted_month_year }}</p>
    </div>

    <!-- Employee Details Table -->
    <div class="row mb-4">
        <div class="col-md-6">
            <table class="table table-sm table-bordered">
                <tr>
                    <th width="40%">Employee Name:</th>
                    <td>{{ $salarySlip->employee->name }}</td>
                </tr>
                <tr>
                    <th>Employee ID:</th>
                    <td>{{ $salarySlip->employee->employeeDetail->employee_id ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Designation:</th>
                    <td>{{ $salarySlip->employee->employeeDetail->role->name ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-sm table-bordered">
                <tr>
                    <th width="40%">Department:</th>
                    <td>{{ $salarySlip->employee->department ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Date of Joining:</th>
                    <td>{{ $salarySlip->employee->employeeDetail->date_of_joining?->format('d M Y') ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Payment Period:</th>
                    <td>{{ $salarySlip->formatted_month_year }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Attendance Summary -->
    <div class="mb-4">
        <h5 class="border-bottom pb-2">Attendance Summary</h5>
        <div class="row text-center">
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body py-2">
                        <h6 class="card-title mb-1">Working Days</h6>
                        <h4 class="mb-0">{{ $salarySlip->total_working_days }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body py-2">
                        <h6 class="card-title mb-1">Present Days</h6>
                        <h4 class="mb-0">{{ $salarySlip->present_days }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body py-2">
                        <h6 class="card-title mb-1">Absent Days</h6>
                        <h4 class="mb-0">{{ $salarySlip->absent_days }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body py-2">
                        <h6 class="card-title mb-1">Paid Leaves</h6>
                        <h4 class="mb-0">{{ $salarySlip->paid_leaves }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings Table -->
    <div class="mb-4">
        <h5 class="border-bottom pb-2">Earnings</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Earnings Component</th>
                    <th class="text-end">Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td class="text-end">₹{{ number_format($salarySlip->basic_salary, 2) }}</td>
                </tr>
                <tr>
                    <td>House Rent Allowance (HRA)</td>
                    <td class="text-end">₹{{ number_format($salarySlip->hra, 2) }}</td>
                </tr>
                <tr>
                    <td>Special Allowance</td>
                    <td class="text-end">₹{{ number_format($salarySlip->special_allowance, 2) }}</td>
                </tr>
                <tr>
                    <td>Medical Allowance</td>
                    <td class="text-end">₹{{ number_format($salarySlip->medical_allowance, 2) }}</td>
                </tr>
                <tr>
                    <td>Travel Allowance</td>
                    <td class="text-end">₹{{ number_format($salarySlip->travel_allowance, 2) }}</td>
                </tr>
                <tr>
                    <td>Overtime Pay ({{ number_format($salarySlip->overtime_hours, 2) }} hrs)</td>
                    <td class="text-end">₹{{ number_format($salarySlip->overtime_pay, 2) }}</td>
                </tr>
                @if($salarySlip->other_earnings > 0)
                <tr>
                    <td>Other Earnings</td>
                    <td class="text-end">₹{{ number_format($salarySlip->other_earnings, 2) }}</td>
                </tr>
                @endif
                <tr class="table-primary">
                    <td><strong>Gross Salary (A)</strong></td>
                    <td class="text-end"><strong>₹{{ number_format($salarySlip->gross_salary, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Deductions Table -->
    <div class="mb-4">
        <h5 class="border-bottom pb-2">Deductions</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Deduction Component</th>
                    <th class="text-end">Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Provident Fund</td>
                    <td class="text-end">₹{{ number_format($salarySlip->provident_fund, 2) }}</td>
                </tr>
                <tr>
                    <td>Professional Tax</td>
                    <td class="text-end">₹{{ number_format($salarySlip->professional_tax, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax Deducted at Source (TDS)</td>
                    <td class="text-end">₹{{ number_format($salarySlip->tax_deducted, 2) }}</td>
                </tr>
                @if($salarySlip->other_deductions > 0)
                <tr>
                    <td>Other Deductions</td>
                    <td class="text-end">₹{{ number_format($salarySlip->other_deductions, 2) }}</td>
                </tr>
                @endif
                <tr class="table-danger">
                    <td><strong>Total Deductions (B)</strong></td>
                    <td class="text-end"><strong>₹{{ number_format($salarySlip->total_deductions, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Net Salary -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body text-center py-4">
            <h4 class="mb-2">Net Salary (A - B)</h4>
            <h2 class="mb-0"><strong>₹{{ number_format($salarySlip->net_salary, 2) }}</strong></h2>
            <small class="text-white-50">Amount in words: 
                @php
                    // Inline number to words conversion (Indian format)
                    $num = floor($salarySlip->net_salary);
                    $words = '';
                    
                    if ($num == 0) {
                        $words = 'zero';
                    } else {
                        $ones = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
                        $tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
                        
                        $convertToWords = function($n) use ($ones, $tens) {
                            if ($n < 20) return $ones[$n];
                            if ($n < 100) return $tens[floor($n / 10)] . ($n % 10 != 0 ? '-' . $ones[$n % 10] : '');
                            return '';
                        };
                        
                        if ($num >= 10000000) {
                            $words .= $convertToWords(floor($num / 10000000)) . ' crore ';
                            $num %= 10000000;
                        }
                        if ($num >= 100000) {
                            $words .= $convertToWords(floor($num / 100000)) . ' lakh ';
                            $num %= 100000;
                        }
                        if ($num >= 1000) {
                            $words .= $convertToWords(floor($num / 1000)) . ' thousand ';
                            $num %= 1000;
                        }
                        if ($num >= 100) {
                            $words .= $convertToWords(floor($num / 100)) . ' hundred ';
                            $num %= 100;
                        }
                        if ($num > 0) {
                            $words .= $convertToWords($num);
                        }
                    }
                @endphp
                {{ ucwords(trim($words)) }} only
            </small>
        </div>
    </div>

    <!-- Remarks -->
    @if($salarySlip->remarks)
    <div class="mb-3">
        <h5 class="border-bottom pb-2">Remarks</h5>
        <p class="text-muted">{{ $salarySlip->remarks }}</p>
    </div>
    @endif

    <!-- Footer -->
    <div class="row mt-5 pt-4 border-top">
        <div class="col-md-4">
            <p class="text-muted small">Generated on: {{ $salarySlip->generated_at?->format('d M Y, h:i A') ?? 'N/A' }}</p>
        </div>
        <div class="col-md-4 text-center">
            <p class="text-muted small">This is a computer-generated document.</p>
        </div>
        <div class="col-md-4 text-end">
            <p class="text-muted small">Authorized Signatory</p>
        </div>
    </div>
</div>
