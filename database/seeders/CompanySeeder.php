<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'GPA .inc',
            'email' => 'gpa@yahooo.com',
            'tax_number' => '00000000',
            'phone' => '111111111',
            'address' => 'SOmwehre',
            'logo' => null
        ]);
    }
}
