<?php

namespace App\Exports\Sales;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.excel.sales.invoice', [
            'invoices' => Invoice::all()
        ]);
    }
}
