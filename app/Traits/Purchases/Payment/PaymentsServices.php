<?php

namespace App\Traits\Purchases\Payment;

use App\Models\Vendor;
use App\Models\Account;
use App\Models\Payment;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Banking\Transaction\HasTransaction;

trait PaymentsServices
{
    use HasTransaction;

    /**
     * Create a new record of payment
     *
     * @param  integer $account_id
     * @param  integer $vendor_id
     * @param  integer $expense_category_id
     * @param  integer $payment_method_id
     * @param  integer $currency_id
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $recurring
     * @param  string|null $reference
     * @param  string|null $file
     * @return mixed
     */
    public function createPayment (int $account_id, ?int $vendor_id, int $expense_category_id, int $payment_method_id, int $currency_id, string $date, float $amount, ?string $description = null, ?string $recurring = null, ?string $reference = null, ?string $file = null): mixed
    {
        try {
            DB::transaction(function () use ($account_id, $vendor_id, $expense_category_id, $payment_method_id, $currency_id, $date, $amount, $description, $recurring, $reference, $file)
            {
                $payment = Payment::create([
                    'account_id' => $account_id,
                    'vendor_id' => $vendor_id,
                    'expense_category_id' => $expense_category_id,
                    'payment_method_id' => $payment_method_id,
                    'currency_id' => $currency_id,
                    'date' => $date,
                    'amount' => $amount,
                    'description' => $description,
                    'recurring' => $recurring,
                    'reference' => $reference,
                    'file' => $file,
                ]);

                /** Transactions */
                $this->createTransaction(
                    get_class($payment),
                    $payment->id,
                    null,
                    $account_id,
                    null,
                    $expense_category_id,
                    $payment_method_id,
                    ExpenseCategory::find($expense_category_id)->name,
                    'Expense',
                    $amount,
                    $amount,
                    0.00,
                    $description,
                    Vendor::find($payment->vendor_id)->name
                );

                /** Account */
                Account::where('id', $account_id)
                    ->update([
                        'balance' => DB::raw("balance - ${amount}")
                    ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }
        
    /**
     * Update an existing record of payment
     *
     * @param  Payment $payment
     * @param  integer $account_id
     * @param  integer $vendor_id
     * @param  integer $expense_category_id
     * @param  integer $payment_method_id
     * @param  integer $currency_id
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string $recurring
     * @param  string|null $reference
     * @param  string|null $file
     * @return mixed
     */
    public function updatePayment (Payment $payment, int $account_id, int $vendor_id, int $expense_category_id, int $payment_method_id, int $currency_id, string $date, float $amount, ?string $description, string $recurring, ?string $reference, ?string $file): mixed
    {
        try {
            DB::transaction(function () use ($payment, $account_id, $vendor_id, $expense_category_id, $payment_method_id, $currency_id, $date, $amount, $description, $recurring, $reference, $file)
            {
                Account::where('id', $account_id)->update([
                    'balance' => DB::raw("balance + {$payment->amount} - $amount")
                ]);

                $payment->update([
                    'account_id' => $account_id,
                    'vendor_id' => $vendor_id,
                    'expense_category_id' => $expense_category_id,
                    'payment_method_id' => $payment_method_id,
                    'currency_id' => $currency_id,
                    'date' => $date,
                    'amount' => $amount,
                    'description' => $description,
                    'recurring' => $recurring,
                    'reference' => $reference,
                    'file' => $file,
                ]);

                /** Transactions */
                $this->updateTransaction(
                    get_class($payment),
                    $payment->id,
                    null,
                    $account_id,
                    null,
                    $expense_category_id,
                    $payment_method_id,
                    ExpenseCategory::find($expense_category_id)->name,
                    'Expense',
                    $amount,
                    $amount,
                    0.00,
                    $description,
                    Vendor::find($vendor_id)->name
                );
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }
}