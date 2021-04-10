<?php

namespace App\Http\Controllers\Api\Exports\Banking;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use App\Exports\Banking\BankAccountTransferExport;

class BankAccountTransferExportsController extends Controller
{
    private BankAccountTransferExport $transfer;
    
    public function __construct(BankAccountTransferExport $transfer)
    {
        $this->transfer = $transfer;
    }
    
    /**
     * Export transfers to csv
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv()
    {
        $fileName = 'transfer-' . Carbon::now()->toDateTimeString() . '-.csv';

        return $this->transfer
            ->download($fileName, Excel::CSV, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

    /**
     * Export transfers to excel
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excel()
    {
        $fileName = 'transfer-' . Carbon::now()->toDateTimeString() . '-.xlsx';

        return $this->transfer
            ->download($fileName, Excel::XLSX, [
                'Content-Type' => 'text/xlsx'
            ]);
    }
}
