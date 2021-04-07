<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpenseCategory::insert([
            [
                'name' => 'Purchase',
                'hex_code' => '#000000',
                'created_at' => now()
            ],
            [
                'name' => 'Transfer',
                'hex_code' => '#000001',
                'created_at' => now()
            ]
        ]);
    }
}
