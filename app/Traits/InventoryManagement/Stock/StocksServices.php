<?php

namespace App\Traits\InventoryManagement\Stock;

use App\Models\Stock;
use Illuminate\Support\Facades\DB;

trait StocksServices
{

    public function stockOut (array $items)
    {
        $data = [];

        foreach ($items as $item) 
        {
            $data[] = [
                'item_id' => $item['item_id'],
                'stock_out' => $item['quantity']
            ];
        }

        $uniqueKeys = 'item_id';

        $update = [
            'in_stock' => DB::raw('in_stock - values(stock_out)'),
            'stock_out'
        ];

        Stock::upsert($data, $uniqueKeys, $update);
    }

}