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

        dd(json_decode($response->getContent()));

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

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_employee()
    {
        $data = [
            'name' => 'Gene Phillip Artista',
            'email' => 'genephillip222@gmail.com',
            'birthDate' => '1998-12-22',
            'gender' => 'Male',
            'phone' => '111111111',
            'address' => 'Laguna',
            'roleId' => 1,
            'enabled' => true,
            'currencyId' => 1,
            'amount' => 10000,
            'taxNumber' => '111111111',
            'bankAccountNumber' => '111111111111',
            'hiredAt' => '2021-05-05'
        ];

        $response = $this->post(
            '/api/human-resources/employees',
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_employee()
    {
        $data = [
            'id' => 1,
            'name' => 'Gene Phillip Artista',
            'email' => 'genephillip222@gmail.com',
            'birthDate' => '1998-12-22',
            'gender' => 'Male',
            'phone' => '111111111',
            'address' => 'Laguna',
            'roleId' => 1,
            'enabled' => true,
            'currencyId' => 1,
            'amount' => 10000,
            'taxNumber' => '111111111',
            'bankAccountNumber' => '111111111111',
            'hiredAt' => '2021-05-05'
        ];

        $response = $this->put(
            '/api/human-resources/employees',
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
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
