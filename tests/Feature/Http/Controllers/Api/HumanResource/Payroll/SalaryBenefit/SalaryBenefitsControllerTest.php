<?php

namespace Tests\Feature\Http\Controllers\Api\HumanResource\Payroll\SalaryBenefit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalaryBenefitsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_salary_benefits()
    {
        $response = $this->get(
            '/api/human-resources/payrolls/salary-benefits',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_salary_benefit()
    {
        $id = 1;

        $response = $this->get(
            "/api/human-resources/payrolls/salary-benefits/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_salary_benefit()
    {
        $data = [
            'type' => 'Monthly employee',
            'amount' => 1000.00,
            'enabled' => false
        ];

        $response = $this->post(
            '/api/human-resources/payrolls/salary-benefits',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_salary_benefit()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'type' => 'Reward',
            'amount' => 2000.00,
            'enabled' => false
        ];

        $response = $this->put(
            "/api/human-resources/payrolls/salary-benefits/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_salary_benefits()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/human-resources/payrolls/salary-benefits',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
