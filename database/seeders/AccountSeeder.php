<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([
            'currency_id' => 1,
            'name' => 'Cash',
            'number' => 111,
            'opening_balance' => 100.00
        ]);
    }
}
