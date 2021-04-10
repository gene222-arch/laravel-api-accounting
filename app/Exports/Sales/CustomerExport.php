<?php

namespace App\Exports\Sales;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.excel.sales.customer', [
            'customers' => Customer::with('currency')->get()
        ]);
    }
}
