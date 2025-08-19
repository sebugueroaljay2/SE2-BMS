<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentType::create([
            'name' => 'Gcash Payment',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PaymentType::create([
            'name' => 'Cash on pick-up',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
