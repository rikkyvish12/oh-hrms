<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Manager',
                'description' => 'Manages team and projects',
            ],
            [
                'name' => 'Developer',
                'description' => 'Software developer',
            ],
            [
                'name' => 'Tester',
                'description' => 'Quality assurance tester',
            ],
            [
                'name' => 'Sales Executive',
                'description' => 'Handles sales and customer relations',
            ],
            [
                'name' => 'HR Manager',
                'description' => 'Manages human resources',
            ],
            [
                'name' => 'Accountant',
                'description' => 'Manages financial records',
            ],
            [
                'name' => 'Designer',
                'description' => 'UI/UX Designer',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
