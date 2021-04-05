<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::insert([
            [
                'sku' => '11111111',
                'barcode' => '22222222',
                'category_id' => 1,
                'name' => 'Gibson',
                'description' => 'description',
                'price' => 20.5,
                'cost' => 10.5,
                'sold_by' => 'each',
                'is_for_sale' => true,
                'image' => null,
                'created_at' => now()
            ]
        ]);
    }
}
