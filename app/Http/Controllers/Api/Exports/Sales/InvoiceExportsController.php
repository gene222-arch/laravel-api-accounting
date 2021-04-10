<?php

namespace App\Http\Controllers\Api\Exports\Sales;

use App\Exports\Sales\InvoiceExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;

class InvoiceExportsController extends Controller
{
 
    private InvoiceExport $invoice;
    
    public function __construct(InvoiceExport $invoice)
    {
        $this->invoice = $invoice;
    }
    
    /**
     * Export invoices to csv
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv()
    {
        $fileName = 'invoice-' . Carbon::now()->toDateTimeString() . '-.csv';

        return $this->invoice
            ->download($fileName, Excel::CSV, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

    /**
     * Export invoices to excel
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excel()
    {
        $fileName = 'invoice-' . Carbon::now()->toDateTimeString() . '-.xlsx';

        return $this->invoice
            ->download($fileName, Excel::XLSX, [
                'Content-Type' => 'text/xlsx'
            ]);
    }
    
}
