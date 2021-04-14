<?php

namespace App\Traits\Reports;

use Illuminate\Support\Facades\DB;


trait IncomeSummaryServices
{    
    
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
            'monthlyIncomeSummary' => $this->monthlyIncomeSummary($dateFrom, $dateTo, $year)
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

        $whereClause = $year ? 'YEAR(revenues.date) = :year' : 'revenues.date >= :dateFrom && revenues.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                MONTH(revenues.date) - 1 as month,
                income_categories.name as category, 
                IFNULL(SUM(revenues.amount), 0) as amount
            FROM 
                income_categories
            INNER JOIN 
                revenues
            ON 
                revenues.income_category_id = income_categories.id 
            WHERE
                $whereClause
            GROUP BY 
                MONTH(revenues.date), income_categories.id
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
    
    /**
     * Get the list of monthly income
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function monthlyIncomeSummary (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $whereClause = $year ? 'YEAR(revenues.date) = :year' : 'revenues.date >= :dateFrom && revenues.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                MONTH(revenues.date) - 1 as month,
                IFNULL(SUM(revenues.amount), 0) as amount
            FROM 
                income_categories
            INNER JOIN 
                revenues
            ON 
                revenues.income_category_id = income_categories.id 
            WHERE
                $whereClause
            GROUP BY 
                MONTH(revenues.date)
        ", $bindings);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($query as $income) 
        {
            $data[$income->month] = $income->amount;
        }

        return $data;
    }
}