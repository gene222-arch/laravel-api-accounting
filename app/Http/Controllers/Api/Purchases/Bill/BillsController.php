<?php

namespace App\Http\Controllers\Api\Purchases\Bill;

use App\Models\Bill;
use App\Models\Model;
use App\Models\Vendor;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchases\Bill\MailRequest;
use App\Http\Requests\Purchases\Bill\StoreRequest;
use App\Http\Requests\Purchases\Bill\DeleteRequest;
use App\Http\Requests\Purchases\Bill\UpdateRequest;
use App\Http\Requests\Purchases\Bill\PaymentRequest;
use App\Http\Requests\Purchases\Bill\MarkAsPaidRequest;


class BillsController extends Controller
{
    use ApiResponser;

    private Bill $bill;
    
    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
        $this->middleware(['auth:api', 'permission:Manage Bills']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->bill
            ->with([
                'paymentDetail',
                'vendor:id,name'
            ])
            ->latest()
            ->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Send an email to a specified customer.
     *
     * @param MailRequest $request
     * @param Bill $bill
     * @param Vendor $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function email(MailRequest $request, Bill $bill, Vendor $vendor)
    {
        $result = $this->bill->email(
            $bill,
            $vendor,
            $request->subject,
            $request->greeting,
            $request->note,
            $request->footer
        );

        return $result !== true 
            ? $this->error(null, 500)
            : $this->success(null, 'Vendor mailed successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Bill $bill
     * @param MarkAsPaidRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsPaid(MarkAsPaidRequest $request, Bill $bill)
    {
        $result = $this->bill->markAsPaid(
            $bill, 
            $request->account_id,
            $request->currency_id,
            $request->payment_method_id,
            $request->expense_category_id,
            $request->amount,
            $request->description,
            $request->reference
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Bill mark as paid successfully.');
    }
    
    /**
     * Mark a specified resource in storage as received
     *
     * @param  App\Models\Bill $bill
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsReceived(Bill $bill)
    {
        $result = $this->bill->markAsReceived($bill);

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Bill mark as received successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $result = $this->bill->createBill(
            $request->except('items', 'payment_details'),
            $request->bill_number,
            $request->items,
            $request->payment_details
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Bill created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Bill $bill
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Bill $bill)
    {
        $bill = $this->bill
            ->with([
                'items:id,name',
                'paymentDetail',
                'histories',
                'transactions',
                'vendor:id,name'
            ])
            ->find($bill->id);

        return !$bill
            ? $this->noContent()
            : $this->success($bill);
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param PaymentRequest $request
     * @param Bill $bill
     * @return \Illuminate\Http\JsonResponse
     */
    public function payment(PaymentRequest $request, Bill $bill)
    {
        $result = $this->bill->payment(
            $bill,
            $request->account_id,
            $request->currency_id,
            $request->payment_method_id,
            $request->date,
            $request->amount,
            $request->description,
            $request->reference
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Bill payment created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Bill $bill
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Bill $bill)
    {
        $result = $this->bill->updateBill(
            $bill,
            $request->except('id', 'items', 'payment_details'),
            $request->items,
            $request->payment_details
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Bill updated successfully.');
    }

    /**
     * Update the specified resource from storage.
     *
     * @param  Bill  $bill
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Bill $bill)
    {
        $this->bill->cancelBill($bill);

        return $this->success(null, 'Bill cancelled successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->bill->deleteManyBills(
            $request->ids
        );

        return $this->success(null, 'Bill or bills deleted successfully.');
    }
}
