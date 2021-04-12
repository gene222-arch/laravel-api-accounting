<?php

namespace App\Http\Controllers\Api\Item\Discount;

use App\Models\Discount;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Item\Discount\DeleteRequest;
use App\Http\Requests\Item\Discount\StoreRequest;
use App\Http\Requests\Item\Discount\UpdateRequest;

class DiscountsController extends Controller
{
    use ApiResponser;

    private Discount $discount;
    
    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
        $this->middleware(['auth:api', 'permission:Manage Discounts']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->discount
            ->latest()
            ->get(['id', ...(new Discount())->getFillable()]);

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
        $model = $this->discount->create($request->all());

        return $this->success($model, 'Discount created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Discount $discount
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Discount $discount)
    {
        return !$discount
            ? $this->noContent()
            : $this->success($discount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Discount $discount
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Discount $discount)
    {
        $discount->update($request->except('id'));

        return $this->success(null, 'Discount updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->discount->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Discount or discounts deleted successfully.');
    }
}
