<?php

namespace App\Exports\Banking;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.excel.banking.transaction', [
            'transactions' => Transaction::with([
                'account',
                'paymentMethod'
            ])
                ->get()
        ]);
    }
}
