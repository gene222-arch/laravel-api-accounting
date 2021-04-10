<?php

namespace App\Exports\Sales;

use App\Models\Revenue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class RevenueExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.excel.sales.revenue', [
            'revenues' => Revenue::with([
                'account',
                'currency',
                'customer',
                'incomeCategory',
                'paymentMethod'
            ])
                ->get()
        ]);
    }
}
