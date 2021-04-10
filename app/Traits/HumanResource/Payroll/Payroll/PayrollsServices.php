<?php

namespace App\Traits\HumanResource\Payroll\Payroll;

use App\Models\Account;
use App\Models\ExpenseCategory;
use App\Models\Payroll;
use App\Traits\Banking\Transaction\HasTransaction;
use App\Traits\Purchases\Purchase\PurchasesServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait PayrollsServices
{
    use HasTransaction;

    /**
     * Get latest records of payrolls
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPayrolls (): Collection
    {   
        setSqlModeEmpty();

        return Payroll::selectRaw('
            payrolls.name,
            payrolls.from_date,
            payrolls.to_date,
            payrolls.payment_date,
            COUNT(employee_payroll.employee_id) as employee_count,
            payrolls.status,
            SUM(employee_payroll.total_amount) as amount
        ')
            ->join('employee_payroll', 'employee_payroll.payroll_id', '=', 'payrolls.id')
            ->groupBy('payrolls.id')
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of payroll via id
     *
     * @param  int $id
     * @return Payroll|null
     */
    public function getPayrollById (int $id): Payroll|null
    {
        return Payroll::where('id', $id)
            ->with([
                'details',
                'employeeTaxes',
                'employeeBenefits',
                'employeeContributions'
            ])
            ->first();
    }
    
    /**
     * Approve a payroll draft
     *
     * @param  integer $id
     * @return mixed
     */
    public function approve (int $id): mixed
    {
        try {
            DB::transaction(function () use ($id)
            {
                $payroll = Payroll::find($id);

                $totalAmount = $payroll->details->map->pivot->map->total_amount->sum();

                Account::where('id', $payroll->account_id)
                    ->update([
                        'balance' => DB::raw("balance - {$totalAmount}")
                    ]);

                $this->createTransaction(
                    get_class($payroll),
                    $payroll->id,
                    $payroll->account_id,
                    null,
                    $payroll->expense_category_id,
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
     * @param  string $name
     * @param  integer $accountId
     * @param  integer $expenseCategoryId
     * @param  integer $paymentMethodId
     * @param  string $fromDate
     * @param  string $toDate
     * @param  string $paymentDate
     * @param  array $details
     * @param  array|null $taxes
     * @param  array|null $benefits
     * @param  array|null $contributions
     * @param  string $approved
     * @return mixed
     */
    public function createPayroll (string $name, int $accountId, int $expenseCategoryId, int $paymentMethodId, string $fromDate, string $toDate, string $paymentDate, array $details, ?array $taxes, ?array $benefits, ?array $contributions, string $approved): mixed
    {
        try {
            DB::transaction(function () use (
                $name, $accountId, $expenseCategoryId, $paymentMethodId, $fromDate, $toDate, $paymentDate, $details, $benefits, $contributions, $taxes, $approved
            )
            {
                $payroll = Payroll::create([
                    'name' => $name,
                    'account_id' => $accountId,
                    'expense_category_id' => $expenseCategoryId,
                    'payment_method_id' => $paymentMethodId,
                    'from_date' => $fromDate,
                    'to_date' => $toDate,
                    'payment_date' => $paymentDate,
                    'status' => $approved
                ]);

                /** Details */
                $payroll->details()->attach($details);

                /** Employee taxes */
                $taxes && ( $payroll->employeeTaxes()->attach($taxes) );

                /** Employee benefits */
                $benefits && ( $payroll->employeeBenefits()->attach($benefits) );

                /** Employee contributions */
                $contributions && ( $payroll->employeeContributions()->attach($contributions) );

                /** Approve payroll */
                (strtolower($approved) === 'approved') && (  $this->approve($payroll->id) );

            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Create a new record of payroll
     *
     * @param  integer $id
     * @param  string $name
     * @param  integer $accountId
     * @param  integer $expenseCategoryId
     * @param  integer $paymentMethodId
     * @param  string $fromDate
     * @param  string $toDate
     * @param  string $paymentDate
     * @param  array $details
     * @param  array|null $taxes
     * @param  array|null $benefits
     * @param  array|null $contributions
     * @param  string $approved
     * @return mixed
     */
    public function updatePayroll (int $id, string $name, int $accountId, int $expenseCategoryId, int $paymentMethodId, string $fromDate, string $toDate, string $paymentDate, array $details, ?array $taxes, ?array $benefits, ?array $contributions, string $approved): mixed
    {
        try {
            DB::transaction(function () use (
                $id, $name, $accountId, $expenseCategoryId, $paymentMethodId, $fromDate, $toDate, $paymentDate, $details, $taxes, $benefits, $contributions, $approved
            )
            {
                $payroll = Payroll::find($id);

                $payroll->update([
                    'name' => $name,
                    'account_id' => $accountId,
                    'expense_category_id' => $expenseCategoryId,
                    'payment_method_id' => $paymentMethodId,
                    'from_date' => $fromDate,
                    'to_date' => $toDate,
                    'payment_date' => $paymentDate,
                    'status' => $approved
                ]);

                /** Details */
                $payroll->details()->sync($details);

                /** Employee taxes */
                $taxes && ( $payroll->employeeTaxes()->sync($taxes) );
                
                /** Employee benefits */
                $benefits && ( $payroll->employeeBenefits()->sync($benefits) );

                /** Employee contributions */
                $contributions && ( $payroll->employeeContributions()->sync($contributions) );

                /** Approve payroll */
                (strtolower($approved) === 'approved') && ( $this->approve($id) );
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