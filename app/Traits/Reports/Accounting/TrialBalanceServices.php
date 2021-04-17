<?php

namespace App\Traits\Reports\Accounting;

use App\Models\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait TrialBalanceServices
{
    public function trialBalance(string $dateFrom, string $dateTo, int $year = null, string $filter = null): array
    {
        setSqlModeEmpty();

        $andFilterClause = $filter ? 'AND REPLACE(LOWER(chart_of_accounts.name), " ", "-") = :filter' : '';

        $andDateClause = $year 
            ? 'AND YEAR(journal_entries.date) = :year' 
            : 'AND journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];
        $filter && $bindings['filter'] = $filter;

        $query = DB::select(
            "SELECT 	
                LOWER(chart_of_account_types.category) as category,
                chart_of_accounts.name as label,
                SUM(journal_entry_details.debit) as debit,
                SUM(journal_entry_details.credit) as credit
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
                chart_of_account_types.category IN ('Asset', 'Expense', 'Equity')
            $andDateClause
            $andFilterClause
            GROUP BY 
                chart_of_account_types.id 
        ", $bindings);

        $data = [];

        foreach ($query as $trialBalance) 
        {
            $data[$trialBalance->category][] = [
                'name' => $trialBalance->label,
                'debit' => $trialBalance->debit,
                'credit' => $trialBalance->credit
            ];
        }

        return $data;
    }
}