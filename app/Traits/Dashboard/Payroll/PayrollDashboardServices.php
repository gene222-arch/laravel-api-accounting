<?php

namespace App\Traits\Dashboard\Payroll;

use Illuminate\Support\Facades\DB;

trait PayrollDashboardServices
{    
    
    /**
     * dashboard
     *
     * @return array
     */
    public function dashboard (string $dateFrom, string $dateTo, int $year = null): array
    {
        return [
            'generalAnalytics' => $this->generalAnalytics($dateFrom, $dateTo, $year),
            'latestPayrolls' => $this->latestPayrolls($dateFrom, $dateTo, $year),
            'monthlyExpense' => $this->monthlyExpense($dateFrom, $dateTo, $year)
        ];
    }

    /**
     * Get the general analytics
     *
     * @return mixed
     */
    public function generalAnalytics (string $dateFrom, string $dateTo, int $year = null): mixed 
    {
        $totalPayrollwhereClause = $year 
            ? 'AND YEAR(payrolls.created_at) = :payrollYear' 
            : 'AND payrolls.created_at >= :payrollDateFrom && payrolls.created_at <= :payrollDateTo';

        $totalPayCalendarwhereClause = $year 
            ? 'YEAR(pay_calendars.created_at) = :calendarYear' 
            : 'pay_calendars.created_at >= :calendarDateFrom && pay_calendars.created_at <= :calendarDateTo';

        $employeesWhereClause = $year 
            ? 'YEAR(employees.created_at) = :employeeYear' 
            : 'employees.created_at >= :employeeDateFrom && employees.created_at <= :employeeDateTo';

        $totalDeductionWhereClause = $year 
            ? 'AND YEAR(payrolls.payment_date) = :deductionYear' 
            : 'AND payrolls.payment_date >= :deductionDateFrom && payrolls.payment_date <= :deductionDateTo';

        $totoalBenefitWhereClause = $year 
            ? 'AND YEAR(payrolls.payment_date) = :benefitYear' 
            : 'AND payrolls.payment_date >= :benefitDateFrom && payrolls.payment_date <= :benefitDateTo';

        $bindings = $year ? [
            'payrollYear' => $year,
            'calendarYear' => $year,
            'employeeYear' => $year,
            'deductionYear' => $year,
            'benefitYear' => $year
        ] : [ 
            'payrollDateFrom' => $dateFrom,
            'payrollDateTo' => $dateTo,
            'calendarDateFrom' => $dateFrom,
            'calendarDateTo' => $dateTo,
            'employeeDateFrom' => $dateFrom,
            'employeeDateTo' => $dateTo,
            'deductionDateFrom' => $dateFrom,
            'deductionDateTo' => $dateTo,
            'benefitDateFrom' => $dateFrom,
            'benefitDateTo' => $dateTo
        ];

        $query = DB::select(
            "SELECT 
            (
                SELECT 
                    IFNULL(SUM(employee_payroll.total_amount), 0)
                FROM 
                    payrolls
                INNER JOIN 
                    employee_payroll
                ON 
                    employee_payroll.payroll_id = payrolls.id 
                WHERE
                    payrolls.status = 'Approved'
                $totalPayrollwhereClause
            ) as total_payrolls,
            (
                SELECT 
                    COUNT(pay_calendars.id)
                FROM 
                    pay_calendars
                WHERE
                    $totalPayCalendarwhereClause
            ) as total_pay_calendars,
            (
                SELECT 
                    COUNT(employees.id) 
                FROM 
                    employees
                WHERE
                    $employeesWhereClause
            ) as employees,
            (
                SELECT
                    SUM(employee_payroll.deduction)
                FROM
                    payrolls
                INNER JOIN 
                    employee_payroll 
                ON 
                    employee_payroll.payroll_id = payrolls.id
                WHERE
                    payrolls.status = 'Approved'
                $totalDeductionWhereClause
            ) as total_deduction,
            (
                SELECT
                    SUM(employee_payroll.benefit)
                FROM
                    payrolls
                INNER JOIN 
                    employee_payroll 
                ON 
                    employee_payroll.payroll_id = payrolls.id
                WHERE
                    payrolls.status = 'Approved'
                $totoalBenefitWhereClause
            ) as total_benefit
        ", $bindings);

        return reset($query);
    }
    
    /**
     * Get the latest list of payrolls
     *
     * @return array
     */
    public function latestPayrolls (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $whereClause = $year ? 'YEAR(payrolls.created_at) = :year' : 'payrolls.created_at >= :dateFrom && payrolls.created_at <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        return DB::select(
            "SELECT 
                DATE_FORMAT(payrolls.from_date, '%D %M %Y') as from_date,
                DATE_FORMAT(payrolls.to_date, '%D %M %Y') as to_date,
                DATE_FORMAT(payrolls.payment_date, '%D %M %Y') as payment_date,
                COUNT(employee_payroll.employee_id) as employees,
                payrolls.status,
                SUM(employee_payroll.total_amount) as amount 
            FROM 
                payrolls
            INNER JOIN 
                employee_payroll
            ON 
                employee_payroll.payroll_id = payrolls.id 
            WHERE
                $whereClause
            GROUP BY 
                payrolls.id 
            ORDER BY 
                payrolls.created_at
            DESC 
            LIMIT 
            5
        ", $bindings);
    }
    
    /**
     * Get the list of montly payroll expense
     *
     * @return array
     */
    public function monthlyExpense (string $dateFrom, string $dateTo, int $year = null): array 
    {
        setSqlModeEmpty();

        $andWhereClause = $year 
            ? 'AND YEAR(payrolls.payment_date) = :year' 
            : 'AND payrolls.payment_date >= :dateFrom && payrolls.payment_date <= :dateTo';

        $bindings = $year ? ['year' => $year] : [ 'dateFrom' => $dateFrom, 'dateTo' => $dateTo ];

        $query = DB::select(
            "SELECT 
                MONTH(payrolls.payment_date) - 1 as month,
                SUM(employee_payroll.total_amount) as amount 
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
                MONTH(payrolls.payment_date)
            ", $bindings);

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($query as $expense) {
            $data[$expense->month] = $expense->amount;
        }

        return $data;
    }
}