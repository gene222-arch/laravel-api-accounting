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

        $andWhereClause = $year ? 'AND YEAR(transactions.created_at) = :year' : 'AND transactions.created_at >= :dateFrom && transactions.created_at <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 	
                MONTH(transactions.created_at) - 1 as month,
                expense_categories.name as category,
                IFNULL(SUM(transactions.amount), 0) as amount 
            FROM 
                transactions
            LEFT JOIN 
                expense_categories
            ON 
                expense_categories.id = transactions.expense_category_id
            WHERE 
                transactions.type = 'Expense'
            $andWhereClause
            GROUP BY 
                MONTH(transactions.created_at), expense_categories.id
        ",$bindings);

        $months = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $data = [];

        foreach ($query as $expense) 
        {
            if (array_key_exists($expense->category, $data)) 
            {
                $data[$expense->category] = [
                    ...$data[$expense->category],
                    $expense->month => $expense->amount
                ];
            }
            else {
                $data[$expense->category] = [
                    ...$months,
                    $expense->month => $expense->amount
                ];
            }
        }

        return $data;
    }
}