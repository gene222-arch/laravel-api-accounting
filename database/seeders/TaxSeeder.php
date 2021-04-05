<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::insert([
            [
                'name' => 'Sales Tax',
                'rate' => 20,
                'type' => 'Normal',
                'enabled' => true,
                'created_at' => now()
            ],
            [
                'name' => 'Value Added Tax',
                'rate' => 5,
                'type' => 'Normal',
                'enabled' => true,
                'created_at' => now()
            ]
        ]);
    }
}
