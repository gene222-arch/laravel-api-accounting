<?php

namespace App\Http\Controllers\Api\Exports\Banking;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use App\Exports\Banking\TransactionExport;

class TransactionExportsController extends Controller
{
    private TransactionExport $transaction;
    
    public function __construct(TransactionExport $transaction)
    {
        $this->transaction = $transaction;
    }
    
    /**
     * Export transactions to csv
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv()
    {
        $fileName = 'transaction-' . Carbon::now()->toDateTimeString() . '-.csv';

        return $this->transaction
            ->download($fileName, Excel::CSV, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

    /**
     * Export transactions to excel
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excel()
    {
        $fileName = 'transaction-' . Carbon::now()->toDateTimeString() . '-.xlsx';

        return $this->transaction
            ->download($fileName, Excel::XLSX, [
                'Content-Type' => 'text/xlsx'
            ]);
    }
}
