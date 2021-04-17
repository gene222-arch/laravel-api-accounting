<?php

namespace App\Traits\Reports\Accounting;

use App\Models\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait GeneralLedgerServices
{    
    /**
     * General ledger
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @param  string $accountName
     * @return array
     */
    public function generalLedger (string $dateFrom, string $dateTo, int $year = null, string $accountName = null): array 
    {
        setSqlModeEmpty();

        $andClause = $accountName ? 'AND REPLACE(LOWER(chart_of_accounts.name), " ", "-") = :accountName' : '';

        $whereClause = $year 
            ? 'YEAR(journal_entries.date) = :year' 
            : 'journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];
        $accountName && $bindings['accountName'] = $accountName;

        $query = DB::select(
            "SELECT 	
                REPLACE(LOWER(CONCAT(chart_of_accounts.name, ' ', chart_of_accounts.type)), ' ', '_') as name,
                DATE_FORMAT(journal_entries.date, '%d %M %Y') as date,
                journal_entries.description as description,
                journal_entry_details.debit as debit,
                journal_entry_details.credit as credit 
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
            WHERE 
                $whereClause
            $andClause
        ", $bindings);

        $data = [];

        foreach ($query as $generalLedger) 
        {
            $data[$generalLedger->name][] = [
                'date' => $generalLedger->date,
                'description' => $generalLedger->description,
                'debit' => $generalLedger->debit,
                'credit' => $generalLedger->credit
            ];
        }

        return $data;
    }
}