<?php

namespace App\Exports\Banking;

use App\Models\BankAccountTransfer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class BankAccountTransferExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.excel.banking.transfer', [
            'transfers' => BankAccountTransfer::with([
                'sender',
                'receiver',
                'paymentMethod'
            ])
                ->get()
        ]);
    }
}
