<?php

namespace App\Traits\Exports\Item\Item;

use App\Models\Item;
use App\Models\Model;
use Illuminate\Database\Eloquent\Collection;

trait ItemExportable
{    
    /**
     * Get all records of item to be exported as for excel files
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function items (): Collection
    {
        return Item::all();
    }
}