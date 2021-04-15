<?php

namespace App\Traits\HumanResource\Payroll\Payroll;

use App\Models\Account;
use App\Models\ExpenseCategory;
use App\Models\Payroll;
use App\Traits\Banking\Transaction\HasTransaction;
use App\Traits\Purchases\Payment\PaymentsServices;
use App\Traits\Purchases\Purchase\PurchasesServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait PayrollsServices
{
    use HasTransaction, PaymentsServices;
    
    /**
     * Approve a payroll draft
     *
     * @param  Payroll $payroll
     * @return mixed
     */
    public function approve (Payroll $payroll): mixed
    {
        try {
            DB::transaction(function () use ($payroll)
            {
                $totalAmount = $payroll->details->map->pivot->map->total_amount->sum();

                Account::where('id', $payroll->account_id)
                    ->update([
                        'balance' => DB::raw("balance - ${totalAmount}")
                    ]);

                $this->createTransaction(
                    get_class($payroll),
                    $payroll->id,
                    $payroll->name,
                    $payroll->account_id,
                    null,
                    $payroll->expense_category_id,
                    $payroll->payment_method_id,
                    ExpenseCategory::find($payroll->expense_category_id)->name,
                    'Expense',
                    $totalAmount,
                    0.00,
                    $totalAmount,
                    null,
                    null 
                );

            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Create a new record of payroll
     *
     * @param  array $payroll_details
     * @param  string $status
     * @param  array $details
     * @param  array|null $taxes
     * @param  array|null $benefits
     * @param  array|null $contributions
     * @return mixed
     */
    public function createPayroll (array $payroll_details, string $status, array $details, ?array $taxes, ?array $benefits, ?array $contributions): mixed
    {
        try {
            DB::transaction(function () use ($payroll_details, $status, $details, $benefits, $contributions, $taxes)
            {
                /** Payroll */
                $payroll = Payroll::create($payroll_details);

                /** Details */
                $payroll->details()->attach($details);

                /** Employee taxes */
                $taxes && ( $payroll->employeeTaxes()->attach($taxes) );

                /** Employee benefits */
                $benefits && ( $payroll->employeeBenefits()->attach($benefits) );

                /** Employee contributions */
                $contributions && ( $payroll->employeeContributions()->attach($contributions) );

                /** Approve payroll */
                (strtolower($status) === 'approved') && (  $this->approve($payroll) );

            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Create a new record of payroll
     *
     * @param  Payroll $payroll
     * @param  array $payroll_details
     * @param  string $status
     * @param  array $details
     * @param  array|null $taxes
     * @param  array|null $benefits
     * @param  array|null $contributions
     * @return mixed
     */
    public function updatePayroll (Payroll $payroll, array $payroll_details, string $status, array $details, ?array $taxes, ?array $benefits, ?array $contributions): mixed
    {
        try {
            DB::transaction(function () use ($payroll, $payroll_details, $status, $details, $benefits, $contributions, $taxes)
            {
                /** Payroll */
                $payroll->update($payroll_details);

                /** Details */
                $payroll->details()->sync($details);

                /** Employee taxes */
                $taxes && ( $payroll->employeeTaxes()->sync($taxes) );

                /** Employee benefits */
                $benefits && ( $payroll->employeeBenefits()->sync($benefits) );

                /** Employee contributions */
                $contributions && ( $payroll->employeeContributions()->sync($contributions) );

                /** Approve payroll */
                (strtolower($status) === 'approved') && (  $this->approve($payroll) );

            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Delete one or multiple records of payrolls
     *
     * @param  array $ids
     * @return boolean
     */
    public function deletePayrolls (array $ids): bool
    {
        return Payroll::whereIn('id', $ids)->delete();
    }
}