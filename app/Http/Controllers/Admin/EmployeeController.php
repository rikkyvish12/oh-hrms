<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeDetail;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\WelcomeEmail;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        $employees = User::where('user_type', 'employee')
            ->with('employeeDetail.role')
            ->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.employees.create', compact('roles'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'date_of_joining' => 'required|date',
            'role_id' => 'nullable|exists:roles,id',
            'leave_balance' => 'nullable|numeric|min:0',
            // Salary fields validation
            'basic_salary' => 'nullable|numeric|min:0',
            'hra' => 'nullable|numeric|min:0',
            'special_allowance' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'travel_allowance' => 'nullable|numeric|min:0',
            'provident_fund' => 'nullable|numeric|min:0',
            'professional_tax' => 'nullable|numeric|min:0',
            'overtime_rate_per_hour' => 'nullable|numeric|min:0',
        ]);

        // Create user with temporary password
        $password = Str::random(10);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'user_type' => 'employee',
            'is_password_set' => false,
        ]);

        // Create employee detail
        $employeeId = 'EMP' . str_pad($user->id, 5, '0', STR_PAD_LEFT);
        
        EmployeeDetail::create([
            'user_id' => $user->id,
            'employee_id' => $employeeId,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'date_of_joining' => $request->date_of_joining,
            'role_id' => $request->role_id,
            'leave_balance' => $request->leave_balance ?? 12,
            // Salary fields
            'basic_salary' => $request->basic_salary ?? null,
            'hra' => $request->hra ?? null,
            'special_allowance' => $request->special_allowance ?? null,
            'medical_allowance' => $request->medical_allowance ?? null,
            'travel_allowance' => $request->travel_allowance ?? null,
            'provident_fund' => $request->provident_fund ?? 0,
            'professional_tax' => $request->professional_tax ?? 0,
            'overtime_rate_per_hour' => $request->overtime_rate_per_hour ?? 0,
        ]);

        // Send welcome email
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user, $password));
        } catch (\Exception $e) {
            // Continue even if email fails
        }

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee.
     */
    public function show(User $employee)
    {
        $employee->load('employeeDetail.role', 'attendances', 'leaves', 'letters');
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(User $employee)
    {
        $roles = Role::all();
        $employee->load('employeeDetail');
        return view('admin.employees.edit', compact('employee', 'roles'));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'date_of_joining' => 'required|date',
            'role_id' => 'nullable|exists:roles,id',
            'leave_balance' => 'nullable|numeric|min:0',
            // Salary fields validation
            'basic_salary' => 'nullable|numeric|min:0',
            'hra' => 'nullable|numeric|min:0',
            'special_allowance' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'travel_allowance' => 'nullable|numeric|min:0',
            'provident_fund' => 'nullable|numeric|min:0',
            'professional_tax' => 'nullable|numeric|min:0',
            'overtime_rate_per_hour' => 'nullable|numeric|min:0',
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $updateData = [
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'date_of_joining' => $request->date_of_joining,
            'role_id' => $request->role_id,
            'leave_balance' => $request->leave_balance ?? 12,
            // Salary fields
            'basic_salary' => $request->basic_salary ?? null,
            'hra' => $request->hra ?? null,
            'special_allowance' => $request->special_allowance ?? null,
            'medical_allowance' => $request->medical_allowance ?? null,
            'travel_allowance' => $request->travel_allowance ?? null,
            'provident_fund' => $request->provident_fund ?? 0,
            'professional_tax' => $request->professional_tax ?? 0,
            'overtime_rate_per_hour' => $request->overtime_rate_per_hour ?? 0,
        ];

        $employee->employeeDetail()->update($updateData);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    /**
     * Assign leave balance to employee
     */
    public function assignLeaveBalance(Request $request, User $employee)
    {
        $request->validate([
            'leave_balance' => 'required|numeric|min:0',
        ]);

        $employee->employeeDetail()->update([
            'leave_balance' => $request->leave_balance,
        ]);

        return back()->with('success', 'Leave balance assigned successfully.');
    }
}
