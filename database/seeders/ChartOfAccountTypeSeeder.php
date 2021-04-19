<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartOfAccountType;

class ChartOfAccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChartOfAccountType::insert([
            [
                'category' => 'Assets',
                'name' => 'Current Assets'
            ],
            [
                'category' => 'Assets',
                'name' => 'Fixed Assets'
            ],
            [
                'category' => 'Assets',
                'name' => 'Inventory'
            ],
            [
                'category' => 'Assets',
                'name' => 'Non-current Assets'
            ],
            [
                'category' => 'Assets',
                'name' => 'Prepayment'
            ],
            [
                'category' => 'Assets',
                'name' => 'Bank and Cash'
            ],
            [
                'category' => 'Expenses',
                'name' => 'Depreciation'
            ],
            [
                'category' => 'Expenses',
                'name' => 'Direct Costs'
            ],
            [
                'category' => 'Expenses',
                'name' => 'Expense'
            ],
            [
                'category' => 'Equity',
                'name' => 'Equity'
            ],
            [
                'category' => 'Incomes',
                'name' => 'Revenue'
            ],
            [
                'category' => 'Incomes',
                'name' => 'Sales'
            ],
            [
                'category' => 'Incomes',
                'name' => 'Other'
            ],
            [
                'category' => 'Liabilities',
                'name' => 'Current Payable'
            ],
            [
                'category' => 'Liabilities',
                'name' => 'Accounts Payable'
            ],
            [
                'category' => 'Liabilities',
                'name' => 'Interest Payable'
            ],
            [
                'category' => 'Liabilities',
                'name' => 'Income Taxes Payable'
            ],
            [
                'category' => 'Liabilities',
                'name' => 'Bills Payable'
            ],
            [
                'category' => 'Liabilities',
                'name' => 'Bank Account Overdrafts'
            ],
            [
                'category' => 'Liabilities',
                'name' => 'Accrued Expenses'
            ],
            [
                'category' => 'Liabilities',
                'name' => 'Short Term Loans'
            ],
        ]);
    }
}
