<?php

namespace App\Http\Controllers\Api\InventoryManagement\Stock;

use App\Models\StockAdjustment;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryManagement\Stock\StockAdjustment\StoreRequest;
use App\Http\Requests\InventoryManagement\Stock\StockAdjustment\DeleteRequest;
use App\Http\Requests\InventoryManagement\Stock\StockAdjustment\UpdateRequest;

class StockAdjustmentsController extends Controller
{
    use ApiResponser;

    private StockAdjustment $stockAdjustment;
    
    public function __construct(StockAdjustment $stockAdjustment)
    {
        $this->stockAdjustment = $stockAdjustment;
        $this->middleware(['auth:api', 'permission:Manage Stock Adjustments']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->stockAdjustment->getAllStockAdjustments();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $result = $this->stockAdjustment->createStockAdjustment(
            $request->except('adjustment_details'),
            $request->reason,
            $request->adjustment_details
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Stock adjustment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param StockAdjustment $stockAdjustment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(StockAdjustment $stockAdjustment)
    {
        $stockAdjustment = $stockAdjustment->with('details')->first();

        return !$stockAdjustment
            ? $this->noContent()
            : $this->success($stockAdjustment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param StockAdjustment $stockAdjustment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, StockAdjustment $stockAdjustment)
    {
        $result = $this->stockAdjustment->updateStockAdjustment(
            $stockAdjustment,
            $request->except('id', 'adjustment_details'),
            $request->reason,
            $request->adjustment_details
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Stock adjustment update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->stockAdjustment->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Stock adjustment or adjustments deleted successfully.');
    }
}
