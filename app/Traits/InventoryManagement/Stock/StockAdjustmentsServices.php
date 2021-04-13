<?php

namespace App\Traits\InventoryManagement\Stock;

use App\Models\Stock;
use App\Models\StockAdjustment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait StockAdjustmentsServices
{
    
    /**
     * Get latest records of stock adjustments
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllStockAdjustments (): Collection
    {
        setSqlModeEmpty();

        return StockAdjustment::selectRaw('
            stock_adjustments.id,
            stock_adjustments.stock_adjustment_number,
            stock_adjustments.reason,
            stock_adjustments.created_at,
            SUM(stock_adjustment_details.quantity) as quantity
        ')
            ->join('stock_adjustment_details', 'stock_adjustment_details.stock_adjustment_id', '=', 'stock_adjustments.id')
            ->groupBy('stock_adjustments.id')
            ->latest()
            ->get();
    }
    
    /**
     * Create a new stock adjustment record
     *
     * @param  array $stockAdjustmentDetails
     * @param  string $reason
     * @param  array $adjustment_details
     * @return mixed
     */
    public function createStockAdjustment (array $stockAdjustmentDetails, string $reason, array $adjustment_details): mixed
    {
        try {
            DB::transaction(function () use ($stockAdjustmentDetails, $reason, $adjustment_details)
            {
                $stockAdjustment =  StockAdjustment::create($stockAdjustmentDetails);

                $stockAdjustment->details()->attach($adjustment_details);

                $this->updateStocksBy($reason, $adjustment_details);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Update an existing record of stock adjustment
     *
     * @param  StockAdjustment $stockAdjustment
     * @param  array $stockAdjustmentDetails
     * @param  string $reason
     * @param  array $adjustment_details
     * @return mixed
     */
    public function updateStockAdjustment (StockAdjustment $stockAdjustment, array $stockAdjustmentDetails, string $reason, array $adjustment_details): mixed
    {
        try {
            DB::transaction(function () use ($stockAdjustment, $stockAdjustmentDetails, $reason, $adjustment_details)
            {
                $stockAdjustment->update($stockAdjustmentDetails);

                $stockAdjustment->details()->sync($adjustment_details);

                $this->updateStocksBy($reason, $adjustment_details);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

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
                    'bad_stock' => DB::raw('bad_stock + values(stock_out)'),
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
}