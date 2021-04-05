<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IncomeCategory::insert([
            [
                'name' => 'Sales',
                'hex_code' => '#000000',
                'created_at' => now()
            ],
            [
                'name' => 'Deposit',
                'hex_code' => '#000001',
                'created_at' => now()
            ]
        ]);
    }
}
