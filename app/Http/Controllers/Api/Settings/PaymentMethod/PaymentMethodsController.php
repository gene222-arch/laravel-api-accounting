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
        $result = $this->paymentMethod->getAllPaymentMethods();

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
        $model = $this->paymentMethod->createPaymentMethod($request->name);

        return $this->success($model, 'Payment method created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->paymentMethod->getPaymentMethodById($id);

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
        $this->paymentMethod->updatePaymentMethod(
            $request->id,
            $request->name
        );

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
        $this->paymentMethod->deletePaymentMethods($request->ids);

        return $this->success(null, 'Payment method or methods deleted successfully.');
    }
}
