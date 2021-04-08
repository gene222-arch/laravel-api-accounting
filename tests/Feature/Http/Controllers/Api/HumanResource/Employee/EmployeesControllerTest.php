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
        $id = 1;

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
            'firstName' => 'John Phillip',
            'lastName' => 'Artista',
            'email' => 'john@gmail.com',
            'birthDate' => '1998-12-22',
            'gender' => 'Male',
            'phone' => '11111111112',
            'address' => 'Laguna',
            'roleId' => 2,
            'enabled' => true,
            'currencyId' => 1,
            'amount' => 10000,
            'taxNumber' => '111111121',
            'bankAccountNumber' => '11111111112',
            'hiredAt' => '2021-05-05',
            'createUser' => true,
        ];

        $response = $this->post(
            '/api/human-resources/employees',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** @test */
    public function user_can_update_employee()
    {
        $data = [
            'id' => 3,
            'firstName' => 'Gene Phillip Artista',
            'lastName' => 'Artista',
            'email' => 'newemail@gmail.com',
            'birthDate' => '1998-12-22',
            'gender' => 'Male',
            'phone' => '33333333333',
            'address' => 'Laguna',
            'roleId' => 1,
            'enabled' => true,
            'currencyId' => 1,
            'amount' => 10000,
            'taxNumber' => '333333333',
            'bankAccountNumber' => '33333333333',
            'hiredAt' => '2021-05-05',
            'updateUser' => true
        ];

        $response = $this->put(
            '/api/human-resources/employees',
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
