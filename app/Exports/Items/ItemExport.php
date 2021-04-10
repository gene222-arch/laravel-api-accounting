<?php

namespace App\Exports\Items;

use App\Traits\Exports\Item\Item\ItemExportable;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ItemExport implements FromView
{
    use Exportable, ItemExportable;

    /**
     * view
     *
     * @return View
     */
    public function view(): View
    {
        return view('export.excel.items.item', [
            'items' => $this->items()
        ]);
    }
}
