<?php

namespace Tests\Feature\Http\Controllers\Api\HumanResource\Payroll\Payroll;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayrollsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_payrolls()
    {
        $response = $this->get(
            '/api/human-resources/payrolls/run-payrolls',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_payroll()
    {
        $id = 1;

        $response = $this->get(
            "/api/human-resources/payrolls/run-payrolls/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_payroll()
    {
        $data = [
            'name' => 'PR-00013',
            'account_id' => 1,
            'expense_category_id' => 1,
            'payment_method_id' => 1,
            'from_date' => '2021-05-05',
            'to_date' => '2021-05-06',
            'payment_date' => '2021-05-07',
            'status' => 'Approved',
            'details' => [
                [
                    'employee_id' => 1,
                    'salary' => 10000.00,
                    'benefit' => 200.00,
                    'deduction' => 100.00,
                    'total_amount' => 100.00
                ],
                [
                    'employee_id' => 2,
                    'salary' => 10000.00,
                    'benefit' => 200.00,
                    'deduction' => 100.00,
                    'total_amount' => 100.00
                ]
            ],
            'benefits' => [
                [
                    'employee_id' => 1,
                    'salary_benefit_id' => 1,
                    'amount' => 200.00
                ],
                [
                    'employee_id' => 2,
                    'salary_benefit_id' => 1,
                    'amount' => 200.00
                ]
            ],
            'contributions' => [
                [
                    'employee_id' => 1,
                    'contribution_id' => 1,
                    'amount' => 200.00
                ],
                [
                    'employee_id' => 2,
                    'contribution_id' => 2,
                    'amount' => 200.00
                ]
            ],
            'taxes' => [
                [
                    'employee_id' => 1,
                    'tax_id' => 1,
                    'amount' => 2000.00
                ],
                [
                    'employee_id' => 2,
                    'tax_id' => 1,
                    'amount' => 2000.00
                ]
            ],
        ];

        $response = $this->post(
            '/api/human-resources/payrolls/run-payrolls',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_payroll()
    {
        $id = 2;

        $data = [
            'id' => 2,
            'name' => 'PR-00002',
            'account_id' => 1,
            'expense_category_id' => 1,
            'payment_method_id' => 1,
            'from_date' => '2021-05-05',
            'to_date' => '2021-05-06',
            'payment_date' => '2021-05-07',
            'status' => 'Approved',
            'details' => [
                [
                    'employee_id' => 1,
                    'salary' => 10000.00,
                    'benefit' => 200.00,
                    'deduction' => 100.00,
                    'total_amount' => 100.00
                ],
            ],
            'taxes' => [
                [
                    'employee_id' => 1,
                    'tax_id' => 1,
                    'amount' => 2000.00
                ]
            ],
            'benefits' => [
                [
                    'employee_id' => 1,
                    'salary_benefit_id' => 1,
                    'amount' => 200.00
                ]
            ],
            'contributions' => [
                [
                    'employee_id' => 1,
                    'contribution_id' => 1,
                    'amount' => 200.00
                ],
            ],
        ];

        $response = $this->put(
            "/api/human-resources/payrolls/run-payrolls/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_approve_payroll()
    {
        $id = 3;

        $response = $this->put(
            "/api/human-resources/payrolls/run-payrolls/${id}/approve",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_payrolls()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/human-resources/payrolls/run-payrolls',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
