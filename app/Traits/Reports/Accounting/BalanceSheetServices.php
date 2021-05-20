<?php

namespace App\Traits\Reports\Accounting;

use Illuminate\Support\Facades\DB;

trait BalanceSheetServices
{    
    /**
     * Balance sheet
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return void
     */
    public function balanceSheet(string $dateFrom, string $dateTo, int $year = null, string $filter = null)
    {
        setSqlModeEmpty();

        $andClause = $filter ? 'AND REPLACE(LOWER(chart_of_accounts.name), " ", "-") = :filter' : '';

        $whereClause = $year 
            ? 'YEAR(journal_entries.date) = :year' 
            : 'journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];
        $filter && $bindings['filter'] = $filter;

        $query = DB::select(
            "SELECT 	
                LOWER(chart_of_account_types.category) as category,
                REPLACE(LOWER(chart_of_account_types.name), ' ', '_') as name,
                chart_of_accounts.name as label,
                SUM(journal_entry_details.debit) as amount
            FROM 
                journal_entries
            INNER JOIN 
                journal_entry_details
            ON 
                journal_entry_details.journal_entry_id = journal_entries.id 
            INNER JOIN 
                chart_of_accounts 
            ON 
                chart_of_accounts.id = journal_entry_details.chart_of_account_id 
            INNER JOIN 
                chart_of_account_types 
            ON 
                chart_of_account_types.id = chart_of_accounts.chart_of_account_type_id
            WHERE
                $whereClause
            $andClause
                AND chart_of_account_types.category in ('Assets', 'Liabilities', 'Equity')
            GROUP BY 
                chart_of_account_types.id 
        ", $bindings);

        $data = [];

        foreach ($query as $balanceSheet) 
        {
            $data[$balanceSheet->category][$balanceSheet->name][] = [
                'name' => $balanceSheet->label,
                'amount' => $balanceSheet->amount
            ];

            if (isset($data[$balanceSheet->category][$balanceSheet->name])) {
                $total = array_reduce($data[$balanceSheet->category][$balanceSheet->name], function ($totalVal, $curArray) {
                    return $totalVal + $curArray['amount'];
                }, 0);

                $data[$balanceSheet->category]["total_$balanceSheet->name"] = $total;
            }

            if (isset($data[$balanceSheet->category]) && !isset($data["total_$balanceSheet->category"])) {
                $data["total_$balanceSheet->category"] = 0;
            }

            if (isset($data["total_$balanceSheet->category"])) {
                $data["total_$balanceSheet->category"] = $data["total_$balanceSheet->category"] + $balanceSheet->amount;
            }
        }

        return $data;
    }
}