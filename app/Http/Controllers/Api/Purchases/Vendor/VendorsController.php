<?php

namespace App\Http\Controllers\Api\Purchases\Vendor;

use App\Models\Vendor;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchases\Vendor\StoreRequest;
use App\Http\Requests\Purchases\Vendor\DeleteRequest;
use App\Http\Requests\Purchases\Vendor\UpdateRequest;

class VendorsController extends Controller
{
    use ApiResponser;

    private Vendor $vendor;
    
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
        $this->middleware(['auth:api', 'permission:Manage Vendors']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->vendor->getAllVendors();

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
        $vendor = $this->vendor->createVendor(
            $request->currencyId,
            $request->name,
            $request->email,
            $request->phone,
            $request->taxNumber,
            $request->website,
            $request->address,
            $request->reference,
            $request->image,
            $request->enabled
        );

        return $this->success($vendor, 'Vendor created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->vendor->getVendorById($id);

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
        $this->vendor->updateVendor(
            $request->id,
            $request->currencyId,
            $request->name,
            $request->email,
            $request->phone,
            $request->taxNumber,
            $request->website,
            $request->address,
            $request->reference,
            $request->image,
            $request->enabled
        );

        return $this->success(null, 'Vendor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->vendor->deleteVendors($request->ids);

        return $this->success(null, 'Vendor or vendors deleted successfully.');
    }
}
