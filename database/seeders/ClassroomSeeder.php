<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::create([
            'classroom_id' => '1A',
            'classroom_id' => '2B',
            'classroom_id' => '3C',
        ]);
    }
}
