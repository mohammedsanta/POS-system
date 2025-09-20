<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name'       => 'Smartphones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Tablets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Accessories',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Chargers & Adapters',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Earphones & Headphones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Screen Protectors',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Covers & Cases',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Smart Watches',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Power Banks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Memory Cards',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
