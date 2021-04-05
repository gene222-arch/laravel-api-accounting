<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'currency_id' => 1,
            'name' => 'Gene Philip',
            'email' => 'genephillip222@gmail.com',
            'tax_number' => 1232,
            'phone' => 111111111,
            'website' => '',
            'address' => 'Somewhere',
            'reference' => '',
            'created_at' => now()
        ]);
    }
}
