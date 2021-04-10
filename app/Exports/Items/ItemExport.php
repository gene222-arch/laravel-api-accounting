<?php

namespace App\Exports\Items;

use App\Models\Item;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ItemExport implements FromView
{
    use Exportable;

    /**
     * view
     *
     * @return View
     */
    public function view(): View
    {
        return view('export.excel.items.item', [
            'items' => Item::all()
        ]);
    }
}
