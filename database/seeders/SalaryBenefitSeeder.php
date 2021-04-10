<?php

namespace Database\Seeders;

use App\Models\SalaryBenefit;
use Illuminate\Database\Seeder;

class SalaryBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalaryBenefit::insert([
            [
                'type' => 'Reward',
                'amount' => 200
            ],
            [
                'type' => 'Bonus',
                'amount' => 200
            ]
        ]);
    }
}
