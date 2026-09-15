<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@hris.test',
                'role' => 'hr-manager',
                'employee_number' => 'EMP-0001',
                'phone' => '081234567801',
                'gender' => 'male',
                'hire_date' => '2024-01-15',
                'employment_status' => 'permanent',
                'department' => 'HR',
                'position' => 'HR-MGR',
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'siti@hris.test',
                'role' => 'hr-staff',
                'employee_number' => 'EMP-0002',
                'phone' => '081234567802',
                'gender' => 'female',
                'hire_date' => '2024-03-01',
                'employment_status' => 'permanent',
                'department' => 'HR',
                'position' => 'HR-STF',
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@hris.test',
                'role' => 'manager',
                'employee_number' => 'EMP-0003',
                'phone' => '081234567803',
                'gender' => 'male',
                'hire_date' => '2023-07-10',
                'employment_status' => 'permanent',
                'department' => 'OPS',
                'position' => 'MGR',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@hris.test',
                'role' => 'employee',
                'employee_number' => 'EMP-0004',
                'phone' => '081234567804',
                'gender' => 'female',
                'hire_date' => '2025-01-06',
                'employment_status' => 'contract',
                'department' => 'IT',
                'position' => 'DEV',
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky@hris.test',
                'role' => 'employee',
                'employee_number' => 'EMP-0005',
                'phone' => '081234567805',
                'gender' => 'male',
                'hire_date' => '2025-06-02',
                'employment_status' => 'intern',
                'department' => 'FIN',
                'position' => 'FIN-STF',
            ],
        ];

        foreach ($employees as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => 'password',
                ]
            );

            $role = Role::where('slug', $data['role'])->firstOrFail();

            $user->roles()->sync([$role->id]);

            $department = Department::where('code', $data['department'])
                ->firstOrFail();

            $position = Position::where('code', $data['position'])
                ->firstOrFail();

            Employee::updateOrCreate(
                ['employee_number' => $data['employee_number']],
                [
                    'user_id' => $user->id,
                    'phone' => $data['phone'],
                    'gender' => $data['gender'],
                    'hire_date' => $data['hire_date'],
                    'employment_status' => $data['employment_status'],
                    'department_id' => $department->id,
                    'position_id' => $position->id,
                ]
            );
        }
    }
}