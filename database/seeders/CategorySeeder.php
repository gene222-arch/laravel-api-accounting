<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'name' => 'E Guitar',
                'hex_code' => '#000004',
                'created_at' => now()
            ],
            [
                'name' => 'E Phones',
                'hex_code' => '#000005',
                'created_at' => now()
            ]
        ]);
    }
}
