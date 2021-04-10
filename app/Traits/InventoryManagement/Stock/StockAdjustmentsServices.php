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
     * Get a record of stock adjustment via id
     *
     * @param  int $id
     * @return StockAdjustment|null
     */
    public function getStockAdjustmentById (int $id): StockAdjustment|null
    {
        $stockAdjustment = StockAdjustment::find($id);

        return !$stockAdjustment
            ? null 
            : $stockAdjustment->with('details')->first();
    }
    
    /**
     * Create a new stock adjustment record
     *
     * @param  string $stockAdjustmentNumber
     * @param  string $reason
     * @param  array $adjustmentDetails
     * @return mixed
     */
    public function createStockAdjustment (string $stockAdjustmentNumber, string $reason, array $adjustmentDetails): mixed
    {
        try {
            DB::transaction(function () use ($stockAdjustmentNumber, $reason, $adjustmentDetails)
            {
                $stockAdjustment =  StockAdjustment::create([
                    'stock_adjustment_number' => $stockAdjustmentNumber,
                    'reason' => $reason
                ]);

                $stockAdjustment->details()->attach($adjustmentDetails);

                $this->updateStocksBy($reason, $adjustmentDetails);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Update an existing record of stock adjustment
     *
     * @param  integer $id
     * @param  string $stockAdjustmentNumber
     * @param  string $reason
     * @param  array $adjustmentDetails
     * @return mixed
     */
    public function updateStockAdjustment (int $id, string $stockAdjustmentNumber, string $reason, array $adjustmentDetails): mixed
    {
        try {
            DB::transaction(function () use ($id, $stockAdjustmentNumber, $reason, $adjustmentDetails)
            {
                $stockAdjustment = StockAdjustment::find($id);

                $stockAdjustment->update([
                    'stock_adjustment_number' => $stockAdjustmentNumber,
                    'reason' => $reason
                ]);

                $stockAdjustment->details()->sync($adjustmentDetails);

                $this->updateStocksBy($reason, $adjustmentDetails);
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

    /**
     * Delete one or multiple records of StockAdjustments
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteStockAdjustments (array $ids): bool
    {
        return StockAdjustment::whereIn('id', $ids)->delete();
    }
}