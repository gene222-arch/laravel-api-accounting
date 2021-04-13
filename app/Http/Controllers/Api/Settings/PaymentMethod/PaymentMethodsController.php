<?php

namespace App\Http\Controllers\Api\Settings\PaymentMethod;

use App\Models\PaymentMethod;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\PaymentMethod\StoreRequest;
use App\Http\Requests\Settings\PaymentMethod\DeleteRequest;
use App\Http\Requests\Settings\PaymentMethod\UpdateRequest;

class PaymentMethodsController extends Controller
{
    use ApiResponser;

    private PaymentMethod $paymentMethod;
    
    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        $this->middleware(['auth:api', 'permission:Manage Payment Methods']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->paymentMethod
            ->latest()
            ->get(['id', ...$this->paymentMethod->getFillable()]);

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
        $paymentMethod = $this->paymentMethod->create($request->validated());

        return $this->success($paymentMethod, 'Payment method created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param PaymentMethod $paymentMethod
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PaymentMethod $paymentMethod)
    {
        return !$paymentMethod
            ? $this->noContent()
            : $this->success($paymentMethod);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param PaymentMethod $paymentMethod
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->except('id'));

        return $this->success(null, 'Payment method updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->paymentMethod->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Payment method or methods deleted successfully.');
    }
}
