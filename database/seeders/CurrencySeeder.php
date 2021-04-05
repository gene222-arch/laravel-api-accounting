<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::insert([
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'created_at' => now()
            ],
            [
                'name' => 'Philippine Peso',
                'code' => 'PHP',
                'created_at' => now()
            ]
        ]);
    }
}
