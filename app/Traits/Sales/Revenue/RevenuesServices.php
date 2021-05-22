<?php

namespace App\Traits\Sales\Revenue;

use App\Models\Account;
use App\Models\Customer;
use App\Models\IncomeCategory;
use App\Models\Invoice;
use App\Models\Revenue;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Banking\Transaction\HasTransaction;

trait RevenuesServices
{
    
    use HasTransaction;

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

                /** Transactions */
                $this->createTransaction(
                    get_class($revenue),
                    $revenue->id,
                    null,
                    $revenue->account_id,
                    $revenue->income_category_id,
                    null,
                    $revenue->payment_method_id,
                    IncomeCategory::find($revenue->income_category_id)->name,
                    'Expense',
                    $revenue->amount,
                    $revenue->amount,
                    0.00,
                    $revenue->description,
                    Customer::find($revenue->customer_id)->name
                );

                /** Account */
                Account::where('id', $revenue->account_id)
                    ->update([
                        'balance' => DB::raw("balance + {$revenue->amount}")
                    ]);
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

                /** Transactions */
                $this->updateTransaction(
                    get_class($revenue),
                    $revenue->id,
                    null,
                    $revenue->account_id,
                    $revenue->income_category_id,
                    null,
                    $revenue->payment_method_id,
                    IncomeCategory::find($revenue->income_category_id)->name,
                    'Expense',
                    $revenue->amount,
                    $revenue->amount,
                    0.00,
                    $revenue->description,
                    Customer::find($revenue->customer_id)->name
                );

                /** Account */
                Account::where('id', $revenue->account_id)
                    ->update([
                        'balance' => DB::raw("balance + {$revenue->amount}")
                    ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}