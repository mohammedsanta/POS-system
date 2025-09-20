<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = [
            ['username' => 'mohamed', 'password' => 123456],
            ['username' => 'agayb', 'password' => 123456],
        ];

        foreach ($staff as $user) {
            Staff::create($user);
        }
    }
}
