<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create([
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
