<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discount::insert([
            [
                'name' => 'Feb',
                'rate' => 20,
                'created_at' => now()
            ],
            [
                'name' => 'Mar',
                'rate' => 30,
                'created_at' => now()
            ]
        ]);
    }
}
