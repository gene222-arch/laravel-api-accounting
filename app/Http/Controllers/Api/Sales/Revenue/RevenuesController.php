<?php

namespace App\Http\Controllers\Api\Sales\Revenue;

use App\Models\Revenue;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\Revenue\StoreRequest;
use App\Http\Requests\Sales\Revenue\DeleteRequest;
use App\Http\Requests\Sales\Revenue\UpdateRequest;

class RevenuesController extends Controller
{
    use ApiResponser;

    private Revenue $revenue;
    
    public function __construct(Revenue $revenue)
    {
        $this->revenue = $revenue;
        $this->middleware(['auth:api', 'permission:Manage Revenues']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->revenue->getAllRevenues();

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
        $result = $this->revenue->createRevenue(
            $request->date,
            $request->amount,
            $request->description,
            $request->recurring,
            $request->reference,
            $request->file,
            $request->accountId,
            $request->customerId,
            $request->incomeCategoryId,
            $request->paymentMethodId,
            $request->invoiceId
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Revenue created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->revenue->getRevenueById($id);

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
        $result = $this->revenue->updateRevenue(
            $request->id,
            $request->date,
            $request->amount,
            $request->description,
            $request->recurring,
            $request->reference,
            $request->file,
            $request->accountId,
            $request->customerId,
            $request->incomeCategoryId,
            $request->paymentMethodId,
            $request->invoiceId
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Revenue updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->revenue->deleteRevenues($request->ids);

        return $this->success(null, 'Revenue or revenues deleted successfully.');
    }
}
