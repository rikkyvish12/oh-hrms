<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@ohahrms.com',
            'password' => Hash::make('admin123'),
            'user_type' => 'admin',
            'is_password_set' => true,
        ]);

        // Create employee detail for admin (optional)
        \App\Models\EmployeeDetail::create([
            'user_id' => $admin->id,
            'employee_id' => 'EMP00001',
            'phone' => '1234567890',
            'address' => 'Admin Office',
            'date_of_joining' => now(),
            'leave_balance' => 12,
        ]);

        // Create default IP restriction (allow localhost)
        \App\Models\IpRestriction::create([
            'ip_address' => '127.0.0.1',
            'is_active' => true,
        ]);
        
        // Allow all local network IPs (example: 192.168.x.x)
        \App\Models\IpRestriction::create([
            'ip_address' => '192.168.0.0/16',
            'is_active' => true,
        ]);
    }
}
