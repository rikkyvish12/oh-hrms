<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip - {{ $salarySlip->employee->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0 10px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .attendance-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .attendance-item {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            background-color: #f9f9f9;
        }
        
        .attendance-item h4 {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .attendance-item p {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        
        .net-salary-box {
            background-color: #e3f2fd;
            border: 2px solid #2196f3;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
        }
        
        .net-salary-box h2 {
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .net-salary-box .amount {
            font-size: 24px;
            font-weight: bold;
            color: #1976d2;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #666;
        }
        
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin-left: auto;
            padding-top: 5px;
            text-align: center;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ config('app.name', 'OHA HRMS') }}</h1>
        <p>Salary Slip for {{ $salarySlip->formatted_month_year }}</p>
    </div>

    <!-- Employee Information -->
    <table>
        <tr>
            <th width="25%">Employee Name:</th>
            <td width="25%">{{ $salarySlip->employee->name }}</td>
            <th width="25%">Employee ID:</th>
            <td width="25%">{{ $salarySlip->employee->employeeDetail->employee_id ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Designation:</th>
            <td>{{ $salarySlip->employee->employeeDetail->role->name ?? 'N/A' }}</td>
            <th>Date of Joining:</th>
            <td>{{ $salarySlip->employee->employeeDetail->date_of_joining?->format('d M Y') ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Payment Period:</th>
            <td>{{ $salarySlip->formatted_month_year }}</td>
            <th>Generated Date:</th>
            <td>{{ $salarySlip->generated_at?->format('d M Y') ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Attendance Summary -->
    <div class="section-title">Attendance Summary</div>
    <div class="attendance-grid">
        <div class="attendance-item">
            <h4>Working Days</h4>
            <p>{{ $salarySlip->total_working_days }}</p>
        </div>
        <div class="attendance-item">
            <h4>Present Days</h4>
            <p>{{ $salarySlip->present_days }}</p>
        </div>
        <div class="attendance-item">
            <h4>Absent Days</h4>
            <p>{{ $salarySlip->absent_days }}</p>
        </div>
        <div class="attendance-item">
            <h4>Paid Leaves</h4>
            <p>{{ $salarySlip->paid_leaves }}</p>
        </div>
    </div>

    <!-- Earnings -->
    <div class="section-title">Earnings</div>
    <table>
        <thead>
            <tr>
                <th width="70%">Earnings Component</th>
                <th class="text-right">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td class="text-right">₹{{ number_format($salarySlip->basic_salary, 2) }}</td>
            </tr>
            <tr>
                <td>House Rent Allowance (HRA)</td>
                <td class="text-right">₹{{ number_format($salarySlip->hra, 2) }}</td>
            </tr>
            <tr>
                <td>Special Allowance</td>
                <td class="text-right">₹{{ number_format($salarySlip->special_allowance, 2) }}</td>
            </tr>
            <tr>
                <td>Medical Allowance</td>
                <td class="text-right">₹{{ number_format($salarySlip->medical_allowance, 2) }}</td>
            </tr>
            <tr>
                <td>Travel Allowance</td>
                <td class="text-right">₹{{ number_format($salarySlip->travel_allowance, 2) }}</td>
            </tr>
            <tr>
                <td>Overtime Pay ({{ number_format($salarySlip->overtime_hours, 2) }} hrs)</td>
                <td class="text-right">₹{{ number_format($salarySlip->overtime_pay, 2) }}</td>
            </tr>
            @if($salarySlip->other_earnings > 0)
            <tr>
                <td>Other Earnings</td>
                <td class="text-right">₹{{ number_format($salarySlip->other_earnings, 2) }}</td>
            </tr>
            @endif
            <tr style="background-color: #e3f2fd; font-weight: bold;">
                <td>Gross Salary (A)</td>
                <td class="text-right">₹{{ number_format($salarySlip->gross_salary, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Deductions -->
    <div class="section-title">Deductions</div>
    <table>
        <thead>
            <tr>
                <th width="70%">Deduction Component</th>
                <th class="text-right">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Provident Fund</td>
                <td class="text-right">₹{{ number_format($salarySlip->provident_fund, 2) }}</td>
            </tr>
            <tr>
                <td>Professional Tax</td>
                <td class="text-right">₹{{ number_format($salarySlip->professional_tax, 2) }}</td>
            </tr>
            <tr>
                <td>Tax Deducted at Source (TDS)</td>
                <td class="text-right">₹{{ number_format($salarySlip->tax_deducted, 2) }}</td>
            </tr>
            @if($salarySlip->other_deductions > 0)
            <tr>
                <td>Other Deductions</td>
                <td class="text-right">₹{{ number_format($salarySlip->other_deductions, 2) }}</td>
            </tr>
            @endif
            <tr style="background-color: #ffebee; font-weight: bold;">
                <td>Total Deductions (B)</td>
                <td class="text-right">₹{{ number_format($salarySlip->total_deductions, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Net Salary -->
    <div class="net-salary-box">
        <h2>Net Salary (A - B)</h2>
        <div class="amount">₹{{ number_format($salarySlip->net_salary, 2) }}</div>
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
        <p style="margin-top: 10px; font-size: 11px;">
            Amount in words: {{ ucwords(trim($words)) }} only
        </p>
    </div>

    <!-- Remarks -->
    @if($salarySlip->remarks)
    <div class="section-title">Remarks</div>
    <p style="color: #666; margin-bottom: 15px;">{{ $salarySlip->remarks }}</p>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div>
            <p>This is a computer-generated document.</p>
            <p>Generated on: {{ $salarySlip->generated_at?->format('d M Y, h:i A') ?? 'N/A' }}</p>
        </div>
        <div class="signature">
            <div class="signature-line">
                Authorized Signatory
            </div>
        </div>
    </div>

    <script>
        // Auto-print on load if not from download button
        window.onload = function() {
            // Uncomment the line below to enable auto-print
            // window.print();
        };
    </script>
</body>
</html>
