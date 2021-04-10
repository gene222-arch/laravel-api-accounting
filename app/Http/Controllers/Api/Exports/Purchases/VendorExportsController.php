<?php

namespace App\Http\Controllers\Api\Exports\Purchases;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use App\Exports\Purchases\VendorExport;

class VendorExportsController extends Controller
{
    private VendorExport $vendor;
    
    public function __construct(VendorExport $vendor)
    {
        $this->vendor = $vendor;
    }
    
    /**
     * Export vendors to csv
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv()
    {
        $fileName = 'vendor-' . Carbon::now()->toDateTimeString() . '-.csv';

        return $this->vendor
            ->download($fileName, Excel::CSV, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

    /**
     * Export vendors to excel
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excel()
    {
        $fileName = 'vendor-' . Carbon::now()->toDateTimeString() . '-.xlsx';

        return $this->vendor
            ->download($fileName, Excel::XLSX, [
                'Content-Type' => 'text/xlsx'
            ]);
    }
}
