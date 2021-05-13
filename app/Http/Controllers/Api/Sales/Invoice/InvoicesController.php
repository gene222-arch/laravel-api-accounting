<?php

namespace App\Http\Controllers\Api\Sales\Invoice;

use App\Models\Invoice;
use App\Models\Customer;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\Invoice\MailRequest;
use App\Http\Requests\Sales\Invoice\StoreRequest;
use App\Http\Requests\Sales\Invoice\DeleteRequest;
use App\Http\Requests\Sales\Invoice\UpdateRequest;
use App\Http\Requests\Sales\Invoice\PaymentRequest;
use App\Http\Requests\Sales\Invoice\MarkAsPaidRequest;

class InvoicesController extends Controller
{
    use ApiResponser;

    private Invoice $invoice;
    
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->middleware(['auth:api', 'permission:Manage Invoices']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->invoice
            ->with([
                'paymentDetail',
                'customer'
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
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $result = $this->invoice->createInvoice(
            $request->except('items', 'payment_details'),
            $request->invoice_number,
            $request->items,
            $request->payment_details
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Invoice $invoice)
    {
        $invoice = $this->invoice
            ->with([
                'incomeCategory',
                'customer',
                'currency',
                'items',
                'paymentDetail',
                'histories',
                'transactions'
            ])
            ->find($invoice->id);

        return !$invoice
            ? $this->noContent()
            : $this->success($invoice);
    }
    
   /**
     * Send an email to a specified customer.
     *
     * @param MailRequest $request
     * @param Invoice $invoice
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function mail(MailRequest $request, Invoice $invoice, Customer $customer)
    {
        $result = $this->invoice->mail(
            $invoice,
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
     * Update the specified resource in storage.
     *
     * @param Invoice $invoice
     * @param MarkAsPaidRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsPaid(MarkAsPaidRequest $request, Invoice $invoice)
    {
        $result = $this->invoice->markAsPaid(
            $invoice, 
            $request->account_id,
            $request->payment_method_id,
            $request->amount,
            $request->description,
            $request->reference
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Invoice marked as paid successfully.');
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param PaymentRequest $request
     * @param Invoice $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function payment(PaymentRequest $request, Invoice $invoice)
    {
        $result = $this->invoice->payment(
            $invoice,
            $request->account_id,
            $request->payment_method_id,
            $request->date,
            $request->amount,
            $request->description,
            $request->reference
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Invoice payment created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Invoice $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Invoice $invoice)
    {
        $result = $this->invoice->updateInvoice(
            $invoice,
            $request->except('items', 'payment_details'),
            $request->invoice_number,
            $request->items,
            $request->payment_details
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Invoice updated successfully.');
    }

    /**
     * Update the specified resource from storage.
     *
     * @param  Invoice  $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Invoice $invoice)
    {
        $this->invoice->cancelInvoice($invoice);

        return $this->success(null, 'Invoice cancelled successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->invoice->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Invoice or invoices deleted successfully.');
    }
}
