<?php

namespace App\Traits\Reports;

use App\Traits\Dashboard\Main\MainDashboardServices;
use Illuminate\Support\Facades\DB;


trait IncomeSummaryServices
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
    public function incomeSummary (string $dateFrom, string $dateTo, int $year = null): array 
    {
        return [
            'incomeSummaryPerCategory' => $this->incomeSummaryPerCategory($dateFrom, $dateTo, $year),
            'monthlyIncomeSummary' => $this->monthlyIncome($dateFrom, $dateTo, $year)
        ];  
    }

    /**
     * Get the list of income summary
     *
     * @return array
     */
    public function incomeSummaryPerCategory (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $andWhereClause = $year ? 'AND YEAR(transactions.created_at) = :year' : 'AND transactions.created_at >= :dateFrom && transactions.created_at <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 	
                MONTH(transactions.created_at) - 1 as month,
                income_categories.name as category,
                IFNULL(SUM(transactions.amount), 0) as amount 
            FROM 
                transactions
            INNER JOIN 
                income_categories
            ON 
                income_categories.id = transactions.income_category_id
            WHERE 
                transactions.type = 'Income'
            $andWhereClause
            GROUP BY 
                MONTH(transactions.created_at), income_categories.id 
        ", $bindings);

        $data = [];

        $months = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($query as $income) 
        {
            $months = [
                ...$months,
                $income->month => $income->amount
            ];

            $data[$income->category] = $months;
        }

        return $data;
    }

}