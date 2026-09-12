<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Memiliki akses penuh ke seluruh sistem.',
            ],
            [
                'name' => 'HR Manager',
                'slug' => 'hr-manager',
                'description' => 'Mengelola data dan proses HR secara keseluruhan.',
            ],
            [
                'name' => 'HR Staff',
                'slug' => 'hr-staff',
                'description' => 'Menjalankan operasional administrasi HR.',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Mengelola kebutuhan HR pada tim yang dipimpinnya.',
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'description' => 'Mengakses fitur HR untuk kebutuhan pribadi.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [
            // Employee
            ['name' => 'View Employees', 'slug' => 'employee.view'],
            ['name' => 'Create Employees', 'slug' => 'employee.create'],
            ['name' => 'Update Employees', 'slug' => 'employee.update'],
            ['name' => 'Delete Employees', 'slug' => 'employee.delete'],

            // Department
            ['name' => 'View Departments', 'slug' => 'department.view'],
            ['name' => 'Create Departments', 'slug' => 'department.create'],
            ['name' => 'Update Departments', 'slug' => 'department.update'],
            ['name' => 'Delete Departments', 'slug' => 'department.delete'],

            // Position
            ['name' => 'View Positions', 'slug' => 'position.view'],
            ['name' => 'Create Positions', 'slug' => 'position.create'],
            ['name' => 'Update Positions', 'slug' => 'position.update'],
            ['name' => 'Delete Positions', 'slug' => 'position.delete'],

            // Attendance
            ['name' => 'View Attendance', 'slug' => 'attendance.view'],
            ['name' => 'Create Attendance', 'slug' => 'attendance.create'],
            ['name' => 'Update Attendance', 'slug' => 'attendance.update'],

            // Schedule
            ['name' => 'View Schedules', 'slug' => 'schedule.view'],
            ['name' => 'Create Schedules', 'slug' => 'schedule.create'],
            ['name' => 'Update Schedules', 'slug' => 'schedule.update'],
            ['name' => 'Delete Schedules', 'slug' => 'schedule.delete'],

            // Overtime
            ['name' => 'View Overtime', 'slug' => 'overtime.view'],
            ['name' => 'Create Overtime', 'slug' => 'overtime.create'],
            ['name' => 'Approve Overtime', 'slug' => 'overtime.approve'],

            // Leave
            ['name' => 'View Leave', 'slug' => 'leave.view'],
            ['name' => 'Create Leave', 'slug' => 'leave.create'],
            ['name' => 'Update Leave', 'slug' => 'leave.update'],
            ['name' => 'Approve Leave', 'slug' => 'leave.approve'],

            // Payroll
            ['name' => 'View Payroll', 'slug' => 'payroll.view'],
            ['name' => 'Create Payroll', 'slug' => 'payroll.create'],
            ['name' => 'Update Payroll', 'slug' => 'payroll.update'],
            ['name' => 'Approve Payroll', 'slug' => 'payroll.approve'],

            // Report
            ['name' => 'View Reports', 'slug' => 'report.view'],
            ['name' => 'Export Reports', 'slug' => 'report.export'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Role → Permission Mapping
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::where('slug', 'super-admin')->firstOrFail();
        $hrManager = Role::where('slug', 'hr-manager')->firstOrFail();
        $hrStaff = Role::where('slug', 'hr-staff')->firstOrFail();
        $manager = Role::where('slug', 'manager')->firstOrFail();
        $employee = Role::where('slug', 'employee')->firstOrFail();

        // Super Admin → semua permission
        $superAdmin->permissions()->sync(
            Permission::pluck('id')
        );

        // HR Manager
        $hrManager->permissions()->sync(
            Permission::whereIn('slug', [
                'employee.view',
                'employee.create',
                'employee.update',
                'employee.delete',

                'department.view',
                'department.create',
                'department.update',
                'department.delete',

                'position.view',
                'position.create',
                'position.update',
                'position.delete',

                'attendance.view',

                'schedule.view',
                'schedule.create',
                'schedule.update',
                'schedule.delete',

                'overtime.view',
                'overtime.approve',

                'leave.view',
                'leave.approve',

                'payroll.view',
                'payroll.approve',

                'report.view',
                'report.export',
            ])->pluck('id')
        );

        // HR Staff
        $hrStaff->permissions()->sync(
            Permission::whereIn('slug', [
                'employee.view',
                'employee.create',
                'employee.update',

                'department.view',
                'position.view',

                'attendance.view',
                'attendance.create',
                'attendance.update',

                'schedule.view',

                'overtime.view',
                'overtime.create',

                'leave.view',
                'leave.create',
                'leave.update',

                'payroll.view',

                'report.view',
            ])->pluck('id')
        );

        // Manager
        $manager->permissions()->sync(
            Permission::whereIn('slug', [
                'employee.view',

                'attendance.view',

                'overtime.view',
                'overtime.approve',

                'leave.view',
                'leave.approve',

                'report.view',
            ])->pluck('id')
        );

        // Employee
        $employee->permissions()->sync(
            Permission::whereIn('slug', [
                'employee.view',

                'attendance.view',

                'leave.view',
                'leave.create',

                'overtime.view',
                'overtime.create',

                'payroll.view',
            ])->pluck('id')
        );

        /*
        |--------------------------------------------------------------------------
        | Assign Super Admin to existing Admin user
        |--------------------------------------------------------------------------
        */

        $admin = User::where('email', 'admin@hris.test')->first();

        if ($admin) {
            $admin->roles()->syncWithoutDetaching([
                $superAdmin->id,
            ]);
        }
    }
}