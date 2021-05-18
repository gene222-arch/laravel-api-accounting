<?php

namespace App\Traits\Reports;

use App\Traits\Dashboard\Main\MainDashboardServices;

trait IncomeVsExpenseServices
{
    use IncomeSummaryServices, ExpenseSummaryServices, MainDashboardServices;
    
    /**
     * Income vs expense summary
     *
     * @param  string $fromDate
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function incomeVsExpenseSummary (string $fromDate, string $dateTo, int $year = null): array 
    {   
        $incomeAndExpensePerCategory = array_merge(
            $this->incomeSummaryPerCategory($fromDate, $dateTo, $year),
            $this->expenseSummaryPerCategory($fromDate, $dateTo, $year)
        );

        return [
            'monthlyIncomeVsExpense' => $this->monthlyProfit($fromDate, $dateTo, $year),
            'incomeAndExpensePerCategory' => $incomeAndExpensePerCategory
        ];
    }
}