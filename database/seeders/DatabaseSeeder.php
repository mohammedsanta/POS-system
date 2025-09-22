<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Owner;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Auth seeder

        Owner::create([
            'username' => 'mohamed',
            'password' => Hash::make('123456'),
        ]);

        Owner::create([
            'username' => 'agayb',
            'password' => Hash::make('123456'),
        ]);

        // 

        $this->call([
            // CategorySeeder::class,
            // ProductSeeder::class,
            // ProductBarcodeSeeder::class,
            StaffSeeder::class,
            // PurchaseSeeder::class,
            // PurchaseItemSeeder::class,
        ]);
    }
}
