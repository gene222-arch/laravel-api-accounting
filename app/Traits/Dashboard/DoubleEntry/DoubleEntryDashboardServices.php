<?php

namespace App\Traits\Dashboard\DoubleEntry;

use App\Models\Account;
use App\Models\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait DoubleEntryDashboardServices
{    
    
    /**
     * Double entry dashboard
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  int $year
     * @return array
     */
    public function dashboard (string $dateFrom, string $dateTo, int $year = null): array
    {
        $income = $this->latestIncomeByChartOfAccounts($dateFrom, $dateTo, $year);
        $expense = $this->latestExpenseByChartOfAccounts($dateFrom, $dateTo, $year);

        $payables = $this->payables($dateFrom, $dateTo, $year);
        $receivables = $this->receivables($dateFrom, $dateTo, $year);
        $upcoming = [
            'amount' => \number_format($receivables->amount - $payables->amount, 2)
        ];

        return [    
            'totalIncome' => $income['totalIncome'],
            'receivables' => $receivables,
            'totalExpense' => $expense['totalExpense'],
            'payables' => $payables,
            'totalProfit' => $income['totalIncome'] - $expense['totalExpense'],
            'upcoming' => $upcoming,
            'accountBalances' => Account::all(['id', 'name', 'balance']),
            'incomeByChartOfAccounts' => $this->incomeByChartOfAccounts($dateFrom, $dateTo, $year),
            'expenseByChartOfAccounts' => $this->expenseByChartOfAccounts($dateFrom, $dateTo, $year),
            'latestIncomeByChartOfAccounts' => $income['latestIncomes'],
            'latestExpenseByChartOfAccounts' => $expense['latestExpenses'],
            'cashFlow' => [
                'monthlyExpenseByChartOfAccounts' => $this->monthlyExpenseByChartOfAccounts($dateFrom, $dateTo, $year),
                'monthlyIncomeByChartOfAccounts' => $this->monthlyIncomeByChartOfAccounts($dateFrom, $dateTo, $year),
                'monthlyProfitByChartOfAccounts' => $this->monthlyProfitByChartOfAccounts($dateFrom, $dateTo, $year),
            ]
        ];
    }

    /**
     * Get the list of expense by chart of accounts
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function expenseByChartOfAccounts (string $dateFrom, string $dateTo, int $year = null): array
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(journal_entries.date) = :year' 
            : 'AND journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        return DB::select(
            "SELECT 
                chart_of_accounts.name,
                IFNULL(SUM(journal_entry_details.debit), 0) as amount
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
                chart_of_account_types.category = 'Expenses'
            $andWhereClause
            GROUP BY 
                chart_of_accounts.id
        ", $bindings);
    }

    /**
     * Get the list of income by chart of accounts
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function incomeByChartOfAccounts (string $dateFrom, string $dateTo, int $year = null): array
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(journal_entries.date) = :year' 
            : 'AND journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        return DB::select(
            "SELECT 
                chart_of_accounts.name,
                IFNULL(SUM(journal_entry_details.debit), 0) as amount
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
                chart_of_account_types.category = 'Incomes'
            $andWhereClause
            GROUP BY 
                chart_of_accounts.id
        ", $bindings);
    }

    /**
     * Get the list of latest expense by chart of accounts
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function latestExpenseByChartOfAccounts (string $dateFrom, string $dateTo, int $year = null): array
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(journal_entries.date) = :year' 
            : 'AND journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                DATE_FORMAT(journal_entries.date, '%d %M %Y') as date,
                chart_of_accounts.name as name,
                IFNULL(SUM(journal_entry_details.debit), 0) as amount
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
                chart_of_account_types.category = 'Expenses'
            $andWhereClause
            GROUP BY 
                journal_entries.id 
            ORDER BY 
                journal_entries.date
            DESC
        ", $bindings);

        $totalExpense = 0;

        foreach ($query as $latestIncome) {
            $totalExpense += $latestIncome->amount;
        }

        return [
            'totalExpense' => $totalExpense,
            'latestExpenses' => $query
        ];
    }

    /**
     * Get the list of latest income by chart of accounts
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function latestIncomeByChartOfAccounts (string $dateFrom, string $dateTo, int $year = null): array
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(journal_entries.date) = :year' 
            : 'AND journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                DATE_FORMAT(journal_entries.date, '%d %M %Y') as date,
                chart_of_accounts.name as name,
                IFNULL(SUM(journal_entry_details.debit), 0) as amount
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
                chart_of_account_types.category = 'Incomes'
            $andWhereClause
            GROUP BY 
                journal_entries.id 
            ORDER BY 
                journal_entries.date
            DESC
        ", $bindings);

        $totalIncome = 0;

        foreach ($query as $latestExpense) {
            $totalIncome += $latestExpense->amount;
        }

        return [
            'totalIncome' => $totalIncome,
            'latestIncomes' => $query
        ];
    }
    
    /**
     * Get the list of expenses per monthly records
     *
     * @param  mixed $dateFrom
     * @param  mixed $dateTo
     * @param  mixed $year
     * @return array
     */
    public function monthlyExpenseByChartOfAccounts (string $dateFrom, string $dateTo, int $year = null): array
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(journal_entries.date) = :year' 
            : 'AND journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                MONTH(journal_entries.date) - 1 as month,
                chart_of_accounts.name as name,
                IFNULL(SUM(journal_entry_details.debit), 0) as amount
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
                chart_of_account_types.category = 'Expenses'
            $andWhereClause
            GROUP BY 
                MONTH(journal_entries.date)         
        ", $bindings);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($query as $monthlyExpense) {
            $data = [
                ...$data,
                $monthlyExpense->month => floatval($monthlyExpense->amount)
            ];
        }

        return $data;
    }

    /**
     * Get the list of incomes per monthly records
     *
     * @param  mixed $dateFrom
     * @param  mixed $dateTo
     * @param  mixed $year
     * @return array
     */
    public function monthlyIncomeByChartOfAccounts (string $dateFrom, string $dateTo, int $year = null): array
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(journal_entries.date) = :year' 
            : 'AND journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                MONTH(journal_entries.date) - 1 as month,
                chart_of_accounts.name as name,
                IFNULL(SUM(journal_entry_details.debit), 0) as amount
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
                chart_of_account_types.category = 'Incomes'
            $andWhereClause
            GROUP BY 
                MONTH(journal_entries.date)         
        ", $bindings);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($query as $monthlyIncome) {
            $data = [
                ...$data,
                $monthlyIncome->month => floatval($monthlyIncome->amount) 
            ];
        }

        return $data;
    }

    /**
     * Get the list of monthly profit
     *
     * @return array
     */
    public function monthlyProfitByChartOfAccounts (string $dateFrom, string $dateTo, int $year = null): array 
    {
        $monthlyIncome = $this->monthlyIncomeByChartOfAccounts($dateFrom, $dateTo, $year);
        $monthlyExpense = $this->monthlyExpenseByChartOfAccounts($dateFrom, $dateTo, $year);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($monthlyIncome as $month => $income) 
        {
            foreach ($monthlyExpense as $expenseMonth => $expense) 
            {
                if ($month === $expenseMonth) {
                    $data[$month] = (float) $income - (float) $expense;
                }
            }
        }

        return $data;
    }
    
    /**
     * Payables
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return mixed
     */
    public function payables (string $dateFrom, string $dateTo, int $year = null): mixed
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(journal_entries.date) = :year' 
            : 'AND journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                IFNULL(SUM(journal_entry_details.credit), 0) as amount
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
                chart_of_accounts.name = 'Accounts Payable'
            $andWhereClause
        ", $bindings);

        return reset($query);
    }

    /**
     * Receivables
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return mixed
     */
    public function receivables (string $dateFrom, string $dateTo, int $year = null): mixed
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(journal_entries.date) = :year' 
            : 'AND journal_entries.date >= :dateFrom && journal_entries.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT
                IFNULL(SUM(journal_entry_details.debit), 0) as amount
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
                chart_of_accounts.name = 'Accounts Receivable'
            $andWhereClause
        ", $bindings);

        return reset($query);
    }
}