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
    public function dashboard (string $dateFrom, string $dateTo, int $year = null): array 
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
        $andRevenueWhereClause = $year 
            ? 'AND YEAR(transactions.created_at) = :revenueYear' 
            : 'AND transactions.created_at >= :dateFrom && transactions.created_at <= :dateTo';

        $invoiceWhereClause = $year 
            ? 'YEAR(invoices.date) = :invoiceYear' 
            : 'invoices.date >= :invoiceDateFrom && invoices.date <= :invoiceDateTo';
        
        $andPaymentWhereClause = $year 
            ? 'AND YEAR(transactions.created_at) = :paymentYear' 
            : 'AND transactions.created_at >= :paymentDateFrom && transactions.created_at <= :paymentDateTo';

        $billWhereClause = $year 
            ? 'YEAR(bills.date) = :billYear' 
            : 'bills.date >= :billDateFrom && bills.date <= :billDateTo';

        $revenueProfitWhereClause = $year 
            ? 'AND YEAR(transactions.created_at) = :revenueProfitYear' 
            : 'AND transactions.created_at >= :profitRevenueDateFrom && transactions.created_at <= :profitRevenueDateTo';

        $paymentProfitWhereClause = $year 
            ? 'AND YEAR(transactions.created_at) = :paymentProfityear' 
            : 'AND transactions.created_at >= :profitPaymentDateFrom && transactions.created_at <= :profitPaymentDateTo';

        $upcomingBillWhereClause = $year 
            ? 'YEAR(bills.date) = :upcomingBillYear' 
            : 'bills.date >= :upcomingBillDateFrom && bills.date <= :upcomingBillDateTo';

        $upcomingInvoiceWhereClause = $year 
            ? 'YEAR(invoices.date) = :upcomingInvoiceYear' 
            : 'invoices.date >= :upcomingInvoiceDateFrom && invoices.date <= :upcomingInvoiceDateTo';

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
        $query = DB::select(
            "SELECT 
            (
                SELECT 
                    SUM(transactions.amount)
                FROM 
                    transactions
                WHERE 
                    transactions.`type` = 'Income'
                $andRevenueWhereClause
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
                    SUM(transactions.amount)
                FROM 
                    transactions
                WHERE 
                    transactions.`type` = 'Expense'
                $andPaymentWhereClause
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
                        SUM(transactions.amount)
                    FROM 
                        transactions
                    WHERE 
                        transactions.`type` = 'Income'
                    $revenueProfitWhereClause
                ) - (
                    SELECT 
                        SUM(transactions.amount)
                    FROM 
                        transactions
                    WHERE 
                        transactions.`type` = 'Expense'
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

        return reset($query);
    }
    
    /**
     * Get the list of latest income
     *
     * @return array
     */
    public function latestIncome (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $andWhereClause = $year ? 'AND YEAR(transactions.created_at) = :year' : 'AND transactions.created_at >= :dateFrom && transactions.created_at <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        return DB::select(
            "SELECT 	
                    DATE_FORMAT(transactions.created_at, '%d %M %Y') as paid_at,
                    income_categories.name as category,
                    IFNULL(SUM(transactions.amount), 0) as amount 
                FROM 
                    transactions
                INNER JOIN 
                    income_categories
                ON 
                    income_categories.id = transactions.expense_category_id
                WHERE 
                    transactions.type = 'Income'
                $andWhereClause
                GROUP BY 
                    transactions.id 
                ORDER BY 
                    transactions.created_at
                DESC 
                LIMIT 
                    5
            ",$bindings);
    }
    
    /**
     * Get the list of latest expense
     *
     * @return array
     */
    public function latestExpenses (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $andWhereClause = $year ? 'AND YEAR(transactions.created_at) = :year' : 'AND transactions.created_at >= :dateFrom && transactions.created_at <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        return DB::select(
            "SELECT 	
                    DATE_FORMAT(transactions.created_at, '%d %M %Y') as paid_at,
                    expense_categories.name as category,
                    IFNULL(SUM(transactions.amount), 0) as amount 
                FROM 
                    transactions
                INNER JOIN 
                    expense_categories
                ON 
                    expense_categories.id = transactions.expense_category_id
                WHERE 
                    transactions.type = 'Expense'
                $andWhereClause
                GROUP BY 
                    transactions.id 
                ORDER BY 
                    transactions.created_at
                DESC 
                LIMIT 
                    5
            ",$bindings);
    }
    
    /**
     * Monthly expenses
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function monthlyExpense (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(transactions.created_at) = :year' 
            : 'AND transactions.created_at >= :dateFrom && transactions.created_at <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 	
                MONTH(transactions.created_at) - 1 as month,
                IFNULL(SUM(transactions.amount), 0) as amount 
            FROM 
                transactions
            WHERE 
                transactions.type = 'Expense'
            $andWhereClause
            GROUP BY 
                MONTH(transactions.created_at)
        ",$bindings);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($query as $expense) {
            $data[$expense->month] = $expense->amount;
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

        $andWhereClause = $year 
            ? 'AND YEAR(transactions.created_at) = :year' 
            : 'AND transactions.created_at >= :dateFrom && transactions.created_at <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
        "SELECT 	
                MONTH(transactions.created_at) - 1 as month,
                IFNULL(SUM(transactions.amount), 0) as amount 
            FROM 
                transactions
            WHERE 
                transactions.type = 'Income'
            $andWhereClause
            GROUP BY 
                MONTH(transactions.created_at)
        ",$bindings);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($query as $income) 
        {
            $data[$income->month] = $income->amount;
        }

        return $data;
    }

    /**
     * Get the list of monthly payroll
     *
     * @param  string $dateFrom
     * @param  string $dateTo
     * @param  integer $year
     * @return array
     */
    public function monthlyPayroll (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(payrolls.payment_date) = :year' 
            : 'AND payrolls.payment_date >= :dateFrom && payrolls.payment_date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                MONTH(payrolls.payment_date) - 1 as month,
                IFNULL(SUM(employee_payroll.total_amount), 0) as amount 
            FROM 
                payrolls
            INNER JOIN  
                employee_payroll 
            ON 
                employee_payroll.payroll_id = payrolls.id
            WHERE
                payrolls.status = 'Approved'
            $andWhereClause
            GROUP BY 
                MONTH(payrolls.payment_date)"
            ,$bindings);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($query as $expense) 
        {
            $data[$expense->month] = $expense->amount;
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

        foreach ($monthlyIncome as $month => $income) 
        {
            foreach ($monthlyExpense as $expenseMonth => $expense) 
            {
                if ($month === $expenseMonth) {
                    $data[$month] = number_format($income - $expense, 2);
                }
            }
        }

        return $data;
    }
}