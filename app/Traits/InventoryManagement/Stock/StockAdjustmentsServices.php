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

                (new Stock())->updateStocksBy($reason, $adjustmentDetails);
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

                (new Stock())->updateStocksBy($reason, $adjustmentDetails);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
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