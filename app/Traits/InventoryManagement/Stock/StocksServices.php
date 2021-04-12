<?php

namespace App\Traits\InventoryManagement\Stock;

use App\Models\Stock;
use App\Models\StockAdjustment;
use Illuminate\Support\Facades\DB;

trait StocksServices
{

    /**
     * Increases the stock in of an item from an existing record of stock
     *
     * @param  array $items
     * @return void
     */
    public function incomingStock (array $items): void
    {
        $data = [];

        foreach ($items as $item) 
        {
            $data[] = [
                'item_id' => $item['item_id'],
                'incoming_stock' => $item['quantity']
            ];
        }

        $uniqueKey = 'item_id';

        $update = [
            'incoming_stock' => DB::raw('incoming_stock + values(incoming_stock)'),
        ];

        Stock::upsert($data, $uniqueKey, $update);
    }

    /**
     * Increases the stock in of an item from an existing record of stock
     *
     * @param  array $items
     * @return void
     */
    public function stockIn (array $items): void
    {
        $data = [];

        foreach ($items as $item) 
        {
            $data[] = [
                'item_id' => $item['item_id'],
                'stock_in' => $item['quantity']
            ];
        }

        $uniqueKey = 'item_id';

        $update = [
            'stock_in' => DB::raw('stock_in + values(stock_in)'),
        ];

        Stock::upsert($data, $uniqueKey, $update);
    }

    /**
     * Reduces the in stock while incrementing the stock out of an item through
     * an existing record of stock
     *
     * @param  array $items
     * @return void
     */
    public function stockOut (array $items): void
    {
        $data = [];

        foreach ($items as $item) 
        {
            $data[] = [
                'item_id' => $item['item_id'],
                'stock_out' => $item['quantity']
            ];
        }

        $uniqueKey = 'item_id';

        $update = [
            'in_stock' => DB::raw('in_stock - values(stock_out)'),
            'stock_out'
        ];

        Stock::upsert($data, $uniqueKey, $update);
    }
}