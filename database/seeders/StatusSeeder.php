<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create([
            'name' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Status::create([
            'name' => 'Processing',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Status::create([
            'name' => 'Ready to Pick-Up',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Status::create([
            'name' => 'Released',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Status::create([
            'name' => 'Rejected',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
