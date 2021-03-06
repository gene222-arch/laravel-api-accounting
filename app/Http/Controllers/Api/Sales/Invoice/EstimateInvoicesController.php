<?php

namespace App\Http\Controllers\Api\Sales\Invoice;

use App\Models\Customer;
use App\Models\EstimateInvoice;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\EstimateInvoice\ConvertToInvoiceRequest;
use App\Http\Requests\Sales\EstimateInvoice\MailRequest;
use App\Http\Requests\Sales\EstimateInvoice\StoreRequest;
use App\Http\Requests\Sales\EstimateInvoice\DeleteRequest;
use App\Http\Requests\Sales\EstimateInvoice\UpdateRequest;

class EstimateInvoicesController extends Controller
{
    use ApiResponser;

    private EstimateInvoice $estimateInvoice;
    
    public function __construct(EstimateInvoice $estimateInvoice)
    {
        $this->estimateInvoice = $estimateInvoice;
        $this->middleware(['auth:api', 'permission:Manage Estimate Invoices']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->estimateInvoice
            ->with([
                'paymentDetail',
                'customer:id,name'
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
     * @param EstimateInvoice $estimateInvoice
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function mail(MailRequest $request, EstimateInvoice $estimateInvoice, Customer $customer)
    {
        $result = $this->estimateInvoice->mail(
            $estimateInvoice,
            $customer,
            $request->subject,
            $request->greeting,
            $request->note,
            $request->footer
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Customer mailed successfully.');
    }

    /**
     * Mark a specified estimate invoice as approved
     *
     * @param EstimateInvoice $estimateInvoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsApproved(EstimateInvoice $estimateInvoice)
    {
        $this->estimateInvoice->markAsApproved($estimateInvoice);

        return $this->success(null, 'Estimate invoice mark as approved successfully.');
    }

    /**
     * Mark a specified estimate invoice as refused
     *
     * @param EstimateInvoice $estimateInvoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRefused(EstimateInvoice $estimateInvoice)
    {
        $this->estimateInvoice->markAsRefused($estimateInvoice);

        return $this->success(null, 'Estimate invoice mark as refused successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $result = $this->estimateInvoice->createEstimateInvoice(
            $request->except('items', 'payment_details'),
            $request->estimate_number,
            $request->items,
            $request->payment_details
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Estimate invoice created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConvertToInvoiceRequest $request
     * @param EstimateInvoice $estimateInvoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function convertToInvoice(ConvertToInvoiceRequest $request, EstimateInvoice $estimateInvoice)
    {
        $result = $this->estimateInvoice->toInvoice(
            $estimateInvoice,
            $request->invoice_number,
            $request->order_no,
            $request->date,
            $request->due_date
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Converted to invoice successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param EstimateInvoice $estimateInvoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(EstimateInvoice $estimateInvoice)
    {
        $estimateInvoice = $this->estimateInvoice
            ->with([
                'items:id,name',
                'paymentDetail',
                'customer:id,name',
                'histories'
            ])
            ->find($estimateInvoice->id);

        return !$estimateInvoice
            ? $this->noContent()
            : $this->success($estimateInvoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param EstimateInvoice $estimateInvoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, EstimateInvoice $estimateInvoice)
    {
        $result = $this->estimateInvoice->updateEstimateInvoice(
            $estimateInvoice,
            $request->except('id', 'items', 'payment_details'),
            $request->estimate_number,
            $request->items,
            $request->payment_details
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Estimate invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->estimateInvoice->deleteManyEstimateInvoices(
            $request->ids
        );

        return $this->success(null, 'Estimate invoice or invoices deleted successfully.');
    }
}
