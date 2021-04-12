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
        $result = $this->payment
            ->latest()
            ->get(['id', ...$this->payment->getFillable()]);

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
        $result = $this->payment->createpayment(
            $request->account_id,
            $request->vendor_id,
            $request->expense_category_id,
            $request->payment_method_id,
            $request->currency_id,
            $request->date,
            $request->amount,
            $request->description,
            $request->recurring,
            $request->reference,
            $request->file
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Payment $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Payment $payment)
    {
        return !$payment
            ? $this->noContent()
            : $this->success($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Payment $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Payment $payment)
    {
        $result = $this->payment->updatePayment(
            $payment,
            $request->account_id,
            $request->vendor_id,
            $request->expense_category_id,
            $request->payment_method_id,
            $request->currency_id,
            $request->date,
            $request->amount,
            $request->description,
            $request->recurring,
            $request->reference,
            $request->file
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->payment->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Payment or payments deleted successfully.');
    }
}
