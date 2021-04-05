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
        $result = $this->discount->getAllDiscounts();

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
        $model = $this->discount->createDiscount(
            $request->name,
            $request->rate,
            $request->enabled,
        );

        return $this->success($model, 'Discount created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->discount->getDiscountById($id);

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
        $this->discount->updateDiscount(
            $request->id,
            $request->name,
            $request->rate,
            $request->enabled,
        );

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
        $this->discount->deleteDiscounts($request->ids);

        return $this->success(null, 'Discount or discounts deleted successfully.');
    }
}
