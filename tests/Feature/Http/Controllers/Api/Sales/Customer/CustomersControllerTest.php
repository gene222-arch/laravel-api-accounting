<?php

namespace Tests\Feature\Http\Controllers\Api\Sales\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomersControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_customers()
    {
        $response = $this->get(
            '/api/customers/sales',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_customer()
    {
        $id = 1;

        $response = $this->get(
            "/api/customers/sales/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_customer()
    {
        $data = [
            'name' => 'Gene Phillip Artista',
            'email' => 'genephillip222@gmail.com',
            'taxNumber' => '12345',
            'currency' => 'US Dollar',            
            'phone' => '22222222222',
            'address' => 'Somewhere down there',
            'reference' => 'Nice store'
        ];

        $response = $this->post(
            '/api/customers/sales',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_customer()
    {
        $data = [
            'id' => 3,
            'name' => 'Gene',
            'email' => 'gene@yahoo.com',
            'taxNumber' => '1234',
            'currency' => 'US Dollar',            
            'phone' => '11111111111',
            'website' => '',
            'address' => 'Somewhere down there',
            'reference' => 'Nice store'
        ];

        $response = $this->put(
            '/api/customers/sales',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_customers()
    {
        $data = [
            'ids' => [
                2
            ]
        ];

        $response = $this->delete(
            '/api/customers/sales',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
