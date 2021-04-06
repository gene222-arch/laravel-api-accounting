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
            $request->stockAdjustmentNumber,
            $request->reason,
            $request->adjustmentDetails
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Stock adjustment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->stockAdjustment->getStockAdjustmentById($id);

        return !$result
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $result = $this->stockAdjustment->updateStockAdjustment(
            $request->id,
            $request->stockAdjustmentNumber,
            $request->reason,
            $request->adjustmentDetails
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Stock adjustment created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        return $this->success(null, 'Stock adjustment or adjustments deleted successfully.');
    }
}
