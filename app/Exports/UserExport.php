<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('test', [
            'data' => 'data'
        ]);
    }
}
