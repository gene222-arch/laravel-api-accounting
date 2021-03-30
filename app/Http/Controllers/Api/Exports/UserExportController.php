<?php

namespace App\Http\Controllers\Api\Exports;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class UserExportController extends Controller
{
    /**
     * Generate an excel file
     */
    public function toExcel()
    {
        $fileName = 'user.xlsx';

        $this->storeExcel($fileName);
        return (new UserExport())->download($fileName);
    }

    /**
     * Generate a CSV file
     */
    public function toCSV()
    {
        $fileName = 'user.csv';

        $this->storeCSV($fileName);
        return (new UserExport())->download($fileName);
    }

    /**
     * Store an excel file in the storage
     */
    public function storeExcel(string $fileName)
    {
        FacadesExcel::store(
            new UserExport(),
            "excels/users/${fileName}"
        );
    }

    /**
     * Store an CSV file in the storage
     */
    public function storeCSV(string $fileName)
    {
        FacadesExcel::store(
            new UserExport(),
            "csv/users/${fileName}"
        );
    }
}
