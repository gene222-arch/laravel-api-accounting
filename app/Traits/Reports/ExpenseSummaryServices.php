<?php

namespace App\Traits\Reports;

use App\Models\Model;
use App\Traits\Dashboard\Main\MainDashboardServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait ExpenseSummaryServices
{
    use MainDashboardServices;

    /**
     * Income summary
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function expenseSummary (string $dateFrom, string $dateTo, int $year = null): array 
    {
        return [
            'expenseSummaryPerCategory' => $this->expenseSummaryPerCategory($dateFrom, $dateTo, $year),
            'monthlyExpenseSummary' => $this->monthlyExpense($dateFrom, $dateTo, $year),
        ];  
    }

    /**
     * Expense summary of payments per category
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function expenseSummaryPerCategory (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $whereClause = $year ? 'YEAR(payments.date) = :year' : 'payments.date >= :dateFrom && payments.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                MONTH(payments.date) - 1 as month,
                expense_categories.name as category,
                IFNULL(SUM(payments.amount), 0) as amount
            FROM 
                expense_categories
            LEFT JOIN 
                payments
            ON 
                payments.expense_category_id = expense_categories.id 
            WHERE
                $whereClause
            GROUP BY 
                MONTH(payments.date), expense_categories.id  
        ",$bindings);

        $months = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $data = [];

        foreach ($query as $expense) 
        {
            $months = [
                ...$months,
                $expense->month => $expense->amount
            ];

            $data[$expense->category] = $months;
        }

        return $data;
    }
}