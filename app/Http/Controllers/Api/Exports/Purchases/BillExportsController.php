<?php

namespace App\Http\Controllers\Api\Exports\Purchases;

use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use App\Exports\Purchases\BillExport;

class BillExportsController extends Controller
{
    private BillExport $bill;
    
    public function __construct(BillExport $bill)
    {
        $this->bill = $bill;
    }
    
    /**
     * Export bills to csv
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv()
    {
        $fileName = 'bill-' . Carbon::now()->toDateTimeString() . '-.csv';

        return $this->bill
            ->download($fileName, Excel::CSV, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

    /**
     * Export bills to excel
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excel()
    {
        $fileName = 'bill-' . Carbon::now()->toDateTimeString() . '-.xlsx';

        return $this->bill
            ->download($fileName, Excel::XLSX, [
                'Content-Type' => 'text/xlsx'
            ]);
    }
    
}
