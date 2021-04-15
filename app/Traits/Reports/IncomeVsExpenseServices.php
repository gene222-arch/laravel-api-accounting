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
        return [
            'monthlyIncomeVsExpense' => $this->monthlyProfit($fromDate, $dateTo, $year),
            'monthlyIncomePerCategory' => $this->incomeSummaryPerCategory($fromDate, $dateTo, $year),
            'monthlyExpensePerCategory' => $this->expenseSummaryPerCategory($fromDate, $dateTo, $year)
        ];
    }
}