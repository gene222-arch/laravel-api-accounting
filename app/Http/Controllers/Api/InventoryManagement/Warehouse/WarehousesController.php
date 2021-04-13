<?php

namespace App\Http\Controllers\Api\InventoryManagement\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryManagement\Warehouse\DeleteRequest;
use App\Http\Requests\InventoryManagement\Warehouse\StoreRequest;
use App\Http\Requests\InventoryManagement\Warehouse\UpdateRequest;
use App\Models\Warehouse;
use App\Traits\Api\ApiResponser;

class WarehousesController extends Controller
{
    use ApiResponser;

    private Warehouse $warehouse;
    
    public function __construct(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
        $this->middleware(['auth:api', 'permission:Manage Warehouses']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->warehouse
            ->with('stocks.item')
            ->latest()
            ->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $result = $this->warehouse->createWarehouse(
            $request->except('stocks'),
            $request->stocks
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Warehouse created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Warehouse $warehouse
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Warehouse $warehouse)
    {
        $warehouse = $warehouse->with('stocks.item')->first();
        
        return !$warehouse
            ? $this->noContent()
            : $this->success($warehouse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param Warehouse $warehouse
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Warehouse $warehouse)
    {
        $result = $this->warehouse->updateWarehouse(
            $warehouse,
            $request->except('id', 'stocks'),
            $request->stocks
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Warehouse updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->warehouse->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Warehouse or warehouses deleted successfully.');
    }
}
