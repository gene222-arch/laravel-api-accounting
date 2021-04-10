<?php

namespace Database\Seeders;

use App\Models\Tax;
use Database\Seeders\TaxSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\ItemSeeder;
use Database\Seeders\StockSeeder;
use Database\Seeders\AccountSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\DiscountSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\ContributionSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Database\Seeders\SalaryBenefitSeeder;
use Database\Seeders\IncomeCategorySeeder;
use Database\Seeders\ExpenseCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // CompanySeeder::class,
            // TaxSeeder::class,
            // CurrencySeeder::class,
            // AccountSeeder::class,
            // IncomeCategorySeeder::class,
            // ExpenseCategorySeeder::class,
            // ContributionSeeder::class,
            // PaymentMethodSeeder::class,
            // CategorySeeder::class,
            // DiscountSeeder::class,
            // ItemSeeder::class,
            // SupplierSeeder::class,
            // CustomerSeeder::class,
            // VendorSeeder::class,
            // StockSeeder::class,
            // EmployeeSeeder::class,
            SalaryBenefitSeeder::class
        ]);
    }
}
