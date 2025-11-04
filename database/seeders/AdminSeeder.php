<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            'name' => env('ADMIN_USERNAME') || 'admin',
            'password' => env('ADMIN_PASSWORD') || '123'
        ];

        Admin::insert($admin);
    }
}
