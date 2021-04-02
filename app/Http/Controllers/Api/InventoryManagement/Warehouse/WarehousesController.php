<?php

namespace App\Http\Controllers\Api\InventoryManagement\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventoryanagement\Warehouse\DeleteRequest;
use App\Http\Requests\Inventoryanagement\Warehouse\StoreRequest;
use App\Http\Requests\Inventoryanagement\Warehouse\UpdateRequest;
use App\Models\Warehouse;
use App\Traits\Api\ApiResponser;

class WarehousesController extends Controller
{
    use ApiResponser;

    private Warehouse $warehouse;
    
    public function __construct(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->warehouse->getAllWarehouses();

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
        $model = $this->warehouse->createWarehouse(
            $request->name,
            $request->email,
            $request->phone,
            $request->address,
            $request->defaultWarehouse
        );

        return $this->success($model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->warehouse->getWarehouseById($id);

        return !$result
            ? $this->noContent()
            : $this->success($result);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $this->warehouse->updateWarehouse(
            $request->id,
            $request->name,
            $request->email,
            $request->phone,
            $request->address,
            $request->defaultWarehouse
        );

        return $this->success(null, 'Warehouse updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->warehouse->deleteWarehouses($request->ids);

        return $this->success(null, 'Warehouse or items deleted successfully.');
    }
}
