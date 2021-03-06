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
            '/api/sales/customers',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_customer()
    {
        $id = 1;

        $response = $this->get(
            "/api/sales/customers/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_customer()
    {
        $data = [
            'currency_id' => 1,        
            'name' => 'Gene Phillip Artista',
            'email' => 'genephillip2222@gmail.com',
            'tax_number' => '12335',    
            'phone' => '22222223222',
            'address' => 'Somewhere down there',
            'reference' => 'Nice store',
            'enabled' => true,
        ];

        $response = $this->post(
            '/api/sales/customers',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_customer()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'currency_id' => 1,      
            'name' => 'Gene',
            'email' => 'gene@yahoo.com',
            'tax_number' => '1234',      
            'phone' => '11111111111',
            'website' => '',
            'address' => 'Somewhere down there',
            'reference' => 'Nice store',
            'enabled' => true,
        ];

        $response = $this->put(
            "/api/sales/customers/${id}",
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
            '/api/sales/customers',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
