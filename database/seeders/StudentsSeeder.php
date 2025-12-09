<?php

namespace Database\Seeders;

use App\Models\Students;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'id' => '1',
                'nis' => '1001',
                'name' => 'Aulia Rahman',
                'level' => 'sd',
            ],
            [
                'id' => '2',
                'nis' => '1002',
                'name' => 'Bagas Pratama',
                'level' => 'smp',
            ],
            [
                'id' => '3',
                'nis' => '1003',
                'name' => 'Citra Lestari',
                'level' => 'sma',
            ],
        ];

        foreach ($students as $student) {
            Students::create($student);
        }
    }
}
