<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Mengelola sumber daya manusia dan administrasi kepegawaian.',
            ],
            [
                'name' => 'Information Technology',
                'code' => 'IT',
                'description' => 'Mengelola sistem informasi dan infrastruktur teknologi.',
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Mengelola keuangan dan administrasi finansial.',
            ],
            [
                'name' => 'Operations',
                'code' => 'OPS',
                'description' => 'Mengelola kegiatan operasional perusahaan.',
            ],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['code' => $department['code']],
                $department
            );
        }
    }
}