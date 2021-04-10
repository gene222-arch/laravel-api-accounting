<?php

namespace App\Exports\Purchases;

use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class VendorExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.excel.purchases.vendor', [
            'vendors' => Vendor::with('currency')->get()
        ]);
    }
}
