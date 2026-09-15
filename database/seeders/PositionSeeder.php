<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            [
                'name' => 'HR Manager',
                'code' => 'HR-MGR',
                'description' => 'Mengelola fungsi dan kebijakan sumber daya manusia.',
            ],
            [
                'name' => 'HR Staff',
                'code' => 'HR-STF',
                'description' => 'Menangani administrasi dan operasional HR.',
            ],
            [
                'name' => 'Software Developer',
                'code' => 'DEV',
                'description' => 'Mengembangkan dan memelihara aplikasi perusahaan.',
            ],
            [
                'name' => 'Finance Staff',
                'code' => 'FIN-STF',
                'description' => 'Menangani administrasi dan pencatatan keuangan.',
            ],
            [
                'name' => 'Operations Staff',
                'code' => 'OPS-STF',
                'description' => 'Menangani kegiatan operasional perusahaan.',
            ],
            [
                'name' => 'Manager',
                'code' => 'MGR',
                'description' => 'Mengelola tim dan kegiatan operasional departemen.',
            ],
        ];

        foreach ($positions as $position) {
            Position::updateOrCreate(
                ['code' => $position['code']],
                $position
            );
        }
    }
}