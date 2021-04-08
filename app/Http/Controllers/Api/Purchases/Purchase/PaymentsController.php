<?php

namespace App\Http\Controllers\Api\Purchases\Payment;

use App\Models\Payment;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchases\Payment\StoreRequest;
use App\Http\Requests\Purchases\Payment\DeleteRequest;
use App\Http\Requests\Purchases\Payment\UpdateRequest;

class PaymentsController extends Controller
{
    use ApiResponser;

    private Payment $payment;
    
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->middleware(['auth:api', 'permission:Manage Payments']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->payment->getAllPayments();

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
        $payment = $this->payment->createpayment(
            $request->number,
            $request->accountId,
            $request->vendorId,
            $request->expenseCategoryId,
            $request->paymentMethodId,
            $request->currencyId,
            $request->date,
            $request->amount,
            $request->description,
            $request->recurring,
            $request->reference,
            $request->file
        );

        return $this->success($payment, 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->payment->getpaymentById($id);

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
        $this->payment->updatePayment(
            $request->id,
            $request->number,
            $request->accountId,
            $request->vendorId,
            $request->expenseCategoryId,
            $request->paymentMethodId,
            $request->currencyId,
            $request->date,
            $request->amount,
            $request->description,
            $request->recurring,
            $request->reference,
            $request->file
        );

        return $this->success(null, 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->payment->deletePayments($request->ids);

        return $this->success(null, 'Payment or payments deleted successfully.');
    }
}
