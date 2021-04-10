<?php

namespace App\Http\Controllers\Api\Exports\Purchases;

use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use App\Exports\Purchases\PaymentExport;

class PaymentExportsController extends Controller
{
    private PaymentExport $payment;
    
    public function __construct(PaymentExport $payment)
    {
        $this->payment = $payment;
    }
    
    /**
     * Export payments to csv
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv()
    {
        $fileName = 'payment-' . Carbon::now()->toDateTimeString() . '-.csv';

        return $this->payment
            ->download($fileName, Excel::CSV, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

    /**
     * Export payments to excel
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excel()
    {
        $fileName = 'payment-' . Carbon::now()->toDateTimeString() . '-.xlsx';

        return $this->payment
            ->download($fileName, Excel::XLSX, [
                'Content-Type' => 'text/xlsx'
            ]);
    }
}
