<?php

namespace App\Http\Controllers\Api\InventoryManagement\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryManagement\Supplier\DeleteRequest;
use App\Http\Requests\InventoryManagement\Supplier\StoreRequest;
use App\Http\Requests\InventoryManagement\Supplier\UpdateRequest;
use App\Models\Supplier;
use App\Traits\Api\ApiResponser;

class SuppliersController extends Controller
{
    use ApiResponser;

    private Supplier $supplier;
    
    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->middleware(['auth:api', 'permission:Manage Suppliers']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->supplier->getAllSuppliers();

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
        $model = $this->supplier->createSupplier(
            $request->name,
            $request->email,
            $request->phone,
            $request->mainAddress,
            $request->optionalAddress,
            $request->city,
            $request->zipCode,
            $request->country,
            $request->province
        );

        return $this->success($model, 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->supplier->getSupplierById($id);

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
        $this->supplier->updateSupplier(
            $request->id, 
            $request->name,
            $request->email,
            $request->phone,
            $request->mainAddress,
            $request->optionalAddress,
            $request->city,
            $request->zipCode,
            $request->country,
            $request->province
        );

        return $this->success(null, 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->supplier->deleteSuppliers($request->ids);

        return $this->success(null, 'Supplier or suppliers deleted successfully.');
    }
}
