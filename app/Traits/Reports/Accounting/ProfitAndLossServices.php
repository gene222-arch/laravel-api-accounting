<?php

namespace App\Traits\Reports\Accounting;

use App\Models\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Reports\IncomeSummaryServices;
use App\Traits\Reports\ExpenseSummaryServices;
use App\Traits\Dashboard\Main\MainDashboardServices;

trait ProfitAndLossServices
{
    use IncomeSummaryServices, ExpenseSummaryServices, MainDashboardServices;
    
    /**
     * Profit and loss summary
     *
     * @param  string $fromDate
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function profitAndLoss (string $fromDate, string $dateTo, int $year = null): array 
    {
        return [
            'monthlyIncomeVsExpense' => $this->monthlyProfit($fromDate, $dateTo, $year),
            'monthlyIncomePerCategory' => $this->incomeSummaryPerCategory($fromDate, $dateTo, $year),
            'monthlyExpensePerCategory' => $this->expenseSummaryPerCategory($fromDate, $dateTo, $year)
        ];
    }
}