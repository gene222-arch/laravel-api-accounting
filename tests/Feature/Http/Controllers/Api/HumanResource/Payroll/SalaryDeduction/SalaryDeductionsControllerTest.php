<?php

namespace Tests\Feature\Http\Controllers\Api\HumanResource\Payroll\SalaryDeduction;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalaryDeductionsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_salary_deductions()
    {
        $response = $this->get(
            '/api/human-resources/payrolls/salary-deductions',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_salary_deduction()
    {
        $id = 10;

        $response = $this->get(
            "/api/human-resources/payrolls/salary-deductions/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_salary_deduction()
    {
        $data = [
            'type' => 'Pag ibig',
            'rate' => 2,
            'enabled' => false,
        ];

        $response = $this->post(
            '/api/human-resources/payrolls/salary-deductions',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_salary_deduction()
    {
        $data = [
            'id' => 2,
            'type' => 'Pag ibig',
            'rate' => 5,
            'enabled' => true,
        ];

        $response = $this->put(
            '/api/human-resources/payrolls/salary-deductions',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_salary_deductions()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/human-resources/payrolls/salary-deductions',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
