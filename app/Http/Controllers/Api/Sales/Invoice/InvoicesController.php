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
        $result = $this->invoice->getAllInvoices();

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
            $request->customerId,
            $request->invoiceNumber,
            $request->orderNo,
            $request->date,
            $request->dueDate,
            $request->items,
            $request->paymentDetails
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->invoice->getInvoiceById($id);

        return !$result
            ? $this->noContent()
            : $this->success($result);
    }
    
   /**
     * Send an email to a specified customer.
     *
     * @param MailRequest $request
     * @param Invoice $invoice
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function email(MailRequest $request, Invoice $invoice, Customer $customer)
    {
        $this->invoice->email(
            $invoice,
            $customer,
            $request->subject,
            $request->greeting,
            $request->note,
            $request->footer
        );

        return $this->success(null, 'Customer mailed successfully.');
    }

   /**
     * Update the specified resource in storage.
     *
     * @param integer $id
     * @param MarkAsPaidRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsPaid(MarkAsPaidRequest $request ,$id)
    {
        $result = $this->invoice->markAsPaid(
            $id, 
            $request->amount
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Invoice paid successfully.');
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param PaymentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payment(PaymentRequest $request)
    {
        $result = $this->invoice->payment(
            $request->id,
            $request->date,
            $request->amount,
            $request->account,
            $request->currency,
            $request->description,
            $request->paymentMethod,
            $request->reference
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Payment created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $result = $this->invoice->updateInvoice(
            $request->id,
            $request->customerId,
            $request->invoiceNumber,
            $request->orderNo,
            $request->date,
            $request->dueDate,
            $request->items,
            $request->paymentDetails
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->invoice->deleteInvoices($request->ids);

        return $this->success(null, 'Invoice or invoices deleted successfully.');
    }
}
