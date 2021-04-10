<?php

namespace App\Http\Controllers\Api\Exports\Items\Item;

use App\Http\Controllers\Controller;
use App\Exports\Items\ItemExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;

class ItemExportsController extends Controller
{
    private $item;
    
    public function __construct(ItemExport $item)
    {
        $this->item = $item;
    }
    
    /**
     * Export items to csv
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv()
    {
        $fileName = 'time-' . Carbon::now()->toDateTimeString() . '-.csv';

        return $this->item
            ->download($fileName, Excel::CSV, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

    /**
     * Export items to excel
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excel()
    {
        $fileName = 'time-' . Carbon::now()->toDateTimeString() . '-.xlsx';

        return $this->item
            ->download($fileName, Excel::XLSX, [
                'Content-Type' => 'text/xlsx'
            ]);
    }
    
}
