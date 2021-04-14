<?php

namespace App\Traits\Dashboard\Main;

use App\Models\Company;
use App\Models\Model;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait MainDashboardServices
{            
    /**
     * Display the main dashboard data 
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer|null $year
     * @return array
     */
    public function dashboardData (string $dateFrom, string $dateTo, int $year = null): array 
    {
        return [
            'generalAnalytics' => $this->generalAnalytics($dateFrom, $dateTo, $year),
            'incomeByCategory' => $this->incomeByCategory($dateFrom, $dateTo, $year),
            'expenseByCategory' => $this->expenseByCategory($dateFrom, $dateTo, $year),
            'latestIncome' => $this->latestIncome($dateFrom, $dateTo, $year),
            'latestExpenses' => $this->latestExpenses($dateFrom, $dateTo, $year),
            'currencies' => Currency::all(['id', ...(new Currency())->getFillable()]),
            'cashFlow' => [
                'monthlyIncome' => $this->monthlyIncome($dateFrom, $dateTo, $year),
                'monthlyExpense' => $this->monthlyExpense($dateFrom, $dateTo, $year),
                'monthlyProfit' => $this->monthlyProfit($dateFrom, $dateTo, $year),
            ]
        ];
    }

    /**
     * Get the list of account's balance
     *
     * @return array
     */
    public function accountBalance (): array 
    {
        setSqlModeEmpty();

        return DB::select(
            'SELECT 
                name,
                SUM(balance) as balance 
            FROM 
                accounts 
            GROUP BY 
                accounts.id 
            '
        );
    }

    /**
     * Get the list of expense by category
     *
     * @return array
     */
    public function expenseByCategory (string $dateFrom, string $dateTo, int $year = null): array
    {
        setSqlModeEmpty();

        $whereClause = $year ? 'YEAR(payments.date) = :year' : 'payments.date >= :dateFrom && payments.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        return DB::select(
            "SELECT 
                expense_categories.name,
                IFNULL(SUM(payments.amount), 0) as expense 
            FROM 
                payments
            INNER JOIN 	
                expense_categories
            ON 
                expense_categories.id = payments.expense_category_id
            WHERE 
                $whereClause
            GROUP BY
                payments.expense_category_id"
        ,$bindings);
    }

    /**
     * Get the list of income by category
     *
     * @return mixed
     */
    public function incomeByCategory (string $dateFrom, string $dateTo, int $year = null): mixed
    {
        setSqlModeEmpty();

        $whereClause = $year ? 'YEAR(revenues.date) = :year' : 'revenues.date >= :dateFrom && revenues.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        return DB::select(
            "SELECT 
                income_categories.name,
                IFNULL(SUM(revenues.amount), 0) as income 
            FROM 
                revenues
            INNER JOIN 	
                income_categories
            ON 
                income_categories.id = revenues.income_category_id
            WHERE
                $whereClause
            GROUP BY
                revenues.income_category_id
        ",$bindings);
    }

    /**
     * Get the general analytics
     *
     * @return mixed
     */
    public function generalAnalytics (string $dateFrom, string $dateTo, int $year = null): mixed
    {
        $revenueWhereClause = $year ? 'YEAR(revenues.date) = :revenueYear' : 'revenues.date >= :dateFrom && revenues.date <= :dateTo';
        $invoiceWhereClause = $year ? 'YEAR(invoices.date) = :invoiceYear' : 'invoices.date >= :invoiceDateFrom && invoices.date <= :invoiceDateTo';
        $paymentWhereClause = $year ? 'YEAR(payments.date) = :paymentYear' : 'payments.date >= :paymentDateFrom && payments.date <= :paymentDateTo';
        $billWhereClause = $year ? 'YEAR(bills.date) = :billYear' : 'bills.date >= :billDateFrom && bills.date <= :billDateTo';
        $revenueProfitWhereClause = $year ? 'YEAR(revenues.date) = :revenueProfitYear' : 'revenues.date >= :profitRevenueDateFrom && revenues.date <= :profitRevenueDateTo';
        $paymentProfitWhereClause = $year ? 'YEAR(payments.date) = :paymentProfityear' : 'payments.date >= :profitPaymentDateFrom && payments.date <= :profitPaymentDateTo';
        $upcomingBillWhereClause = $year ? 'YEAR(bills.date) = :upcomingBillYear' : 'bills.date >= :upcomingBillDateFrom && bills.date <= :upcomingBillDateTo';
        $upcomingInvoiceWhereClause = $year ? 'YEAR(invoices.date) = :upcomingInvoiceYear' : 'invoices.date >= :upcomingInvoiceDateFrom && invoices.date <= :upcomingInvoiceDateTo';

        $bindings = $year 
            ? [
                'revenueYear' => $year,
                'invoiceYear' => $year,
                'paymentYear' => $year,
                'billYear' => $year,
                'revenueProfitYear' => $year,
                'paymentProfityear' => $year,
                'upcomingBillYear' => $year,
                'upcomingInvoiceYear' => $year
            ]
            : [
                'revenueDateFrom' => $dateFrom,
                'revenueDateTo' => $dateTo,
                'invoiceDateFrom' => $dateFrom,
                'invoiceDateTo' => $dateTo,
                'paymentDateFrom' => $dateFrom,
                'paymentDateTo' => $dateTo,
                'billDateFrom' => $dateFrom,
                'billDateTo' => $dateTo,
                'profitRevenueDateFrom' => $dateFrom,
                'profitRevenueDateTo' => $dateTo,
                'profitPaymentDateFrom' => $dateFrom,
                'profitPaymentDateTo' => $dateTo,
                'upcomingBillDateFrom' => $dateFrom,
                'upcomingBillDateTo' => $dateTo,
                'upcomingInvoiceDateFrom' => $dateFrom,
                'upcomingInvoiceDateTo' => $dateTo
            ];
        $data = DB::select(
            "SELECT 
            (
                SELECT 
                    IFNULL(SUM(revenues.amount), 0) 
                FROM 
                    revenues
                WHERE
                    $revenueWhereClause
            ) as income,
            (
                SELECT	
                    IFNULL(SUM(invoice_payment_details.amount_due), 0)
                FROM 
                    invoices
                INNER JOIN 	
                    invoice_payment_details
                ON
                    invoice_payment_details.invoice_id = invoices.id 
                WHERE
                    $invoiceWhereClause
            ) as receivables,
            (
                SELECT
                    IFNULL(SUM(payments.amount), 0)
                FROM 
                    payments
                WHERE
                    $paymentWhereClause
            ) as expense,
            (
                SELECT	
                    IFNULL(SUM(bill_payment_details.amount_due), 0)
                FROM 
                    bills
                INNER JOIN 	
                    bill_payment_details
                ON
                    bill_payment_details.bill_id = bills.id 
                WHERE
                    $billWhereClause
            ) as payables,
            (
                (
                    SELECT 
                        IFNULL(SUM(revenues.amount), 0) 
                    FROM 
                        revenues
                    WHERE
                        $revenueProfitWhereClause
                    ) - (
                
                    SELECT
                        IFNULL(SUM(payments.amount), 0)
                    FROM 
                        payments
                    WHERE
                        $paymentProfitWhereClause
                )
            ) as profit,
            (
                SELECT	
                    IFNULL(SUM(bill_payment_details.amount_due), 0)
                FROM 
                    bills
                INNER JOIN 	
                    bill_payment_details
                ON
                    bill_payment_details.bill_id = bills.id 
                WHERE
                    $upcomingBillWhereClause
            ) - 
            (
                SELECT	
                    IFNULL(SUM(invoice_payment_details.amount_due), 0)
                FROM 
                    invoices
                INNER JOIN 	
                    invoice_payment_details
                ON
                    invoice_payment_details.invoice_id = invoices.id 
                WHERE
                    $upcomingInvoiceWhereClause
            ) as upcoming
        ",$bindings);

        return reset($data);
    }
    
    /**
     * Get the list of latest income
     *
     * @return array
     */
    public function latestIncome (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $whereClause = $year ? 'YEAR(revenues.date) = :year' : 'revenues.date >= :dateFrom && revenues.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        return DB::select(
            "SELECT 
                DATE_FORMAT(revenues.date, '%d %M %Y') paid_at,
                income_categories.name as category,
                revenues.amount
            FROM 
                revenues
            INNER JOIN 
                income_categories
            ON 
                income_categories.id = revenues.income_category_id
            WHERE
                $whereClause
            ORDER BY 
                revenues.created_at
            DESC"
        , $bindings);
    }
    
    /**
     * Get the list of latest expense
     *
     * @return array
     */
    public function latestExpenses (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $whereClause = $year ? 'YEAR(payments.date) = :year' : 'payments.date >= :dateFrom && payments.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        return DB::select(
            "SELECT 
                    DATE_FORMAT(payments.date, '%d %M %Y') as paid_at,
                    expense_categories.name as category,
                    payments.amount
                FROM 
                    payments
                INNER JOIN 
                    expense_categories
                ON 
                    expense_categories.id = payments.expense_category_id
                WHERE
                    $whereClause
                ORDER BY 
                    payments.created_at
                DESC
            ",$bindings);
    }
    
    /**
     * Get the list of monthly expense
     *
     * @return array
     */
    public function monthlyExpense (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $whereClause = $year ? 'YEAR(payments.date) = :year' : 'payments.date >= :dateFrom && payments.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $monthlyExpense = DB::select(
            "SELECT 
                MONTH(payments.date) as month,
                IFNULL(SUM(payments.amount), 0) as expense 
            FROM 
                payments
            WHERE
                $whereClause
            GROUP BY 
                MONTH(payments.date)
            ",
            $bindings);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($monthlyExpense as $expense) 
        {
            $data[$expense->month] = $expense->expense;
        }

        return $data;
    }

    /**
     * Get the list of monthly income
     *
     * @return array
     */
    public function monthlyIncome (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $whereClause = $year ? 'YEAR(revenues.date) = :year' : 'revenues.date >= :dateFrom && revenues.date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $monthlyIncome = DB::select(
            "SELECT 
                MONTH(revenues.date) as month,
                IFNULL(SUM(revenues.amount), 0) as income 
            FROM 
                revenues
            WHERE
                $whereClause
            GROUP BY 
                MONTH(revenues.date)"
            ,$bindings);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($monthlyIncome as $income) 
        {
            $data[$income->month] = $income->income;
        }

        return $data;
    }
    
    /**
     * Get the list of monthly profit
     *
     * @return array
     */
    public function monthlyProfit (string $dateFrom, string $dateTo, int $year = null): array 
    {
        $monthlyIncome = $this->monthlyIncome($dateFrom, $dateTo, $year);
        $monthlyExpense = $this->monthlyExpense($dateFrom, $dateTo, $year);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($monthlyIncome as $incomeKey => $incomeValue) 
        {
            foreach ($monthlyExpense as $expenseKey => $expenseValue) 
            {
                if ($incomeKey === $expenseKey)  $data[$incomeKey] = $incomeValue - $expenseValue;
            }
        }

        return $data;
    }
}