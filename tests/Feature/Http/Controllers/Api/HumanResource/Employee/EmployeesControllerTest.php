<?php

namespace Tests\Feature\Http\Controllers\Api\HumanResource\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_employees()
    {
        $response = $this->get(
            '/api/human-resources/employees',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_employee()
    {
        $id = 2;

        $response = $this->get(
            "/api/human-resources/employees/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_employee()
    {
        $data = [
            'employee_details' => [
                'first_name' => 'John Phillip',
                'last_name' => 'Artista',
                'email' => 'john@gmail.com',
                'birth_date' => '1998-12-22',
                'gender' => 'Male',
                'phone' => '11111111112',
                'address' => 'Laguna',
                'enabled' => true,
            ],
            'role_id' => 2,
            'salary_details' => [
                'currency_id' => 1,
                'amount' => 10000,
                'tax_number' => '111111121',
                'bank_account_number' => '11111111112',
                'hired_at' => '2021-05-05',
            ],
            'create_user' => true,
        ];

        $response = $this->post(
            '/api/human-resources/employees',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_employee()
    {
        $id = 2;

        $data = [
            'id' => $id,
            'employee_details' => [
                'first_name' => 'John Phillip',
                'last_name' => 'Artista',
                'email' => 'johngggg@gmail.com',
                'birth_date' => '1998-12-22',
                'gender' => 'Male',
                'phone' => '11111111112',
                'address' => 'Laguna',
                'enabled' => true,
            ],
            'role_id' => 2,
            'salary_details' => [
                'currency_id' => 1,
                'amount' => 10000,
                'tax_number' => '1111111211',
                'bank_account_number' => '11111211211',
                'hired_at' => '2021-05-05',
            ],
            'create_user' => false,
        ];

        $response = $this->put(
            "/api/human-resources/employees/${id}",
            $data,
            $this->apiHeader()
        );  

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_employees()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/human-resources/employees',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
