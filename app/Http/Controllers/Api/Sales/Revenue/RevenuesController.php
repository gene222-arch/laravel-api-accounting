<?php

namespace App\Http\Controllers\Api\Sales\Revenue;

use App\Models\Revenue;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\Revenue\StoreRequest;
use App\Http\Requests\Sales\Revenue\DeleteRequest;
use App\Http\Requests\Sales\Revenue\UpdateStoreRequest;

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
        $result = $this->revenue->with([
            'account',
            'customer',
            'incomeCategory',
        ])
            ->latest()
            ->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UpdateStoreRequest $request)
    {
        $result = $this->revenue->createRevenue($request->validated());

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Revenue created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Revenue $revenue
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Revenue $revenue)
    {
        return !$revenue
            ? $this->noContent()
            : $this->success($revenue);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @param UpdateStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStoreRequest $request, Revenue $revenue)
    {
        $result = $this->revenue->updateRevenue(
            $revenue,
            $request->validated(),
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
