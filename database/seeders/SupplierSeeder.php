<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::insert([
            [
                'name' => 'Supplier 1',
                'email' => 'genephillip222@gmail.com',
                'phone' => '11111111',
                'main_address' => 'Some where',
                'optional_address' => 'Some',
                'city' => 'Some',
                'zip_code' => 2223,
                'country' => 'Philippines',
                'province' => 'Laguna',
                'created_at' => now()
            ],
            [
                'name' => 'Supplier 2',
                'email' => 'Supplier@gmail.com',
                'phone' => '22222222',
                'main_address' => 'Some where',
                'optional_address' => 'Some',
                'city' => 'Some',
                'zip_code' => 2223,
                'country' => 'Philippines',
                'province' => 'Laguna',
                'created_at' => now()
            ]
        ]);
    }
}
