<?php

namespace App\Exports\Purchases;

use App\Models\Bill;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class BillExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.excel.purchases.bill', [
            'bills' => Bill::with([
                'currency',
                'customer',
                'expenseCategory',
                'items',
                'paymentDetail'
            ])
                ->get()
        ]);
    }
}
