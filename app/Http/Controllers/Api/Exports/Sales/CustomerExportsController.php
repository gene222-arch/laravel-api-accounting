<?php

namespace App\Http\Controllers\Api\Exports\Sales;

use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use App\Exports\Sales\CustomerExport;

class CustomerExportsController extends Controller
{
    
    private CustomerExport $customer;
    
    public function __construct(CustomerExport $customer)
    {
        $this->customer = $customer;
    }
    
    /**
     * Export customers to csv
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv()
    {
        $fileName = 'customer-' . Carbon::now()->toDateTimeString() . '-.csv';

        return $this->customer
            ->download($fileName, Excel::CSV, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

    /**
     * Export customers to excel
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excel()
    {
        $fileName = 'customer-' . Carbon::now()->toDateTimeString() . '-.xlsx';

        return $this->customer
            ->download($fileName, Excel::XLSX, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

}
