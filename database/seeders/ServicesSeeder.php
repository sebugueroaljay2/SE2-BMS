<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Barangay Clearance',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Business Permit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Residency Certificates',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Indengency Certificates',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Barangay Health Certificates',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
