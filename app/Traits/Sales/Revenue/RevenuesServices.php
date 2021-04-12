<?php

namespace App\Traits\Sales\Revenue;

use App\Models\Invoice;
use App\Models\Revenue;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait RevenuesServices
{
    
    /**
     * Create a new record of revenue
     *
     * @param  array $revenueDetails
     * @param  Invoice|null $invoice
     * @return mixed
     */
    public function createRevenue (array $revenueDetails, ?Invoice $invoice = null): mixed
    {
        try {
            DB::transaction(function () use ($revenueDetails, $invoice)
            {
                $revenue = Revenue::create($revenueDetails);

                $invoice && $revenue->invoices()->attach($invoice);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of revenue
     *
     * @param  Revenue $revenue
     * @param  array $revenueDetails
     * @param  Invoice|null $invoice
     * @return mixed
     */
    public function updateRevenue (Revenue $revenue, array $revenueDetails, ?Invoice $invoice = null): mixed
    {
        try {
            DB::transaction(function () use ($revenue, $revenueDetails, $invoice)
            {
                $revenue->update($revenueDetails);

                $invoice && $revenue->invoices()->sync($invoice);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}