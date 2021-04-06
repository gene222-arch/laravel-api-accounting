<?php

namespace App\Traits\InventoryManagement\Stock;

use App\Models\Stock;
use App\Models\StockAdjustment;
use Illuminate\Support\Facades\DB;

trait StocksServices
{
    
    /**
     * Update stocks dynamically via reason
     *
     * @param  string $reason
     * @param  array $stocks
     * @return void
     */
    public function updateStocksBy(string $reason, array $stocks): void
    {
        $data = []; 

        $uniqueKey = 'id';

        $update = [];

        switch ($reason) 
        {
            case StockAdjustment::RECEIVED_ITEMS:

                foreach ($stocks as $stock) 
                {
                    $data[] = [
                        'id' => $stock['stock_id'],
                        'stock_in' => $stock['quantity']
                    ];
                }

                $update = [
                    'item_id' => DB::raw('item_id'),
                    'in_stock' => DB::raw('in_stock + values(stock_in)'),
                    'stock_in' => DB::raw('stock_in + values(stock_in)'),
                ];

                break;

            case StockAdjustment::LOSS_ITEMS:
            case StockAdjustment::DAMAGED_ITEMS:

                foreach ($stocks as $stock) 
                {
                    $data[] = [
                        'id' => $stock['stock_id'],
                        'stock_out' => $stock['quantity']
                    ];
                }

                $update = [
                    'item_id' => DB::raw('item_id'),
                    'in_stock' => DB::raw('in_stock - values(stock_out)'),
                    'stock_out' => DB::raw('stock_out + values(stock_out)'),
                ];

                break;       

            case StockAdjustment::INVENTORY_COUNT:

                foreach ($stocks as $stock) 
                {
                    $data[] = [
                        'id' => $stock['stock_id'],
                        'in_stock' => $stock['quantity']
                    ];
                }

                $update = [
                    'item_id' => DB::raw('item_id'),
                    'in_stock'
                ];
                
                break;
        }

        Stock::upsert($data, $uniqueKey, $update);
    }

    /**
     * Increases the bad stock while decrementing the in stock of an item 
     * from an existing record of stock
     *
     * @param  array $items
     * @return void
     */
    public function badStock (array $items): void
    {
        $data = [];

        foreach ($items as $item) 
        {
            $data[] = [
                'item_id' => $item['item_id'],
                'bad_stock' => $item['quantity']
            ];
        }

        $uniqueKey = 'item_id';

        $update = [
            'in_stock' => DB::raw('in_stock - values(bad_stock)'),
            'bad_stock' => DB::raw('bad_stock + values(bad_stock)'),
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