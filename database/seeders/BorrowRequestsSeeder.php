<?php

namespace Database\Seeders;

use App\Models\BorrowRequests;
use Illuminate\Database\Seeder;

class BorrowRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BorrowRequests::create([
            'id' => '1',
            'student_id' => '1',
            'book_id' => '1',
            'status' => 'pending'
        ]);
    }
}
