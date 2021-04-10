<?php

namespace Database\Seeders;

use App\Models\Contribution;
use Illuminate\Database\Seeder;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contribution::insert([
            [
                'name' => 'PAGIBIG',
                'rate' => 2,
                'enabled' => true
            ],
            [
                'name' => 'PHILHEALTH',
                'rate' => 3.50,
                'enabled' => true
            ],
            [
                'name' => 'SSS',
                'rate' => 13,
                'enabled' => true
            ],
            [
                'name' => 'GSIS',
                'rate' => 9,
                'enabled' => true
            ]
        ]);
    }
}
