<?php

namespace App\Exports\Purchases;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.excel.purchases.payment', [
            'payments' => Payment::with([
                'account',
                'currency',
                'vendor',
                'expenseCategory',
                'paymentMethod'
            ])
                ->get()
        ]);
    }
}
