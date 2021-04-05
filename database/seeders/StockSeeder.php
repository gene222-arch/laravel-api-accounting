<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stock::create([
            'item_id' => 1,
            'supplier_id' => 1,
            'in_stock' => 10,
            'stock_in' => 0,
            'stock_out' => 0,
            'bad_stock' => 0,
            'minimum_stock' => 1,
            'created_at' => now()
        ]);
    }
}
