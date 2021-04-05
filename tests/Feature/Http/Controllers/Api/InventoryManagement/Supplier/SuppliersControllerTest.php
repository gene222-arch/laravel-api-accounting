<?php

namespace Tests\Feature\Http\Controllers\Api\InventoryManagement\Supplier;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SuppliersControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_suppliers()
    {
        $response = $this->get(
            '/api/suppliers',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_supplier()
    {
        $id = 1;

        $response = $this->get(
            "/api/suppliers/${id}",
            $this->apiHeader()
        );
 
        $this->assertResponse($response);
    }

    /** @test */
    public function user_can_create_supplier()
    {
        $data = [
            'name' => 'Mc Donalds',
            'email' => 'mcdo@gmail.com',
            'phone' => '2222222222',
            'mainAddress' => 'Somewhere',
            'optionalAddress' => 'Somethere',
            'city' => 'City',
            'zipCode' => '42032',
            'country' => 'Philippines',
            'province' => 'Laguna',
            'enabled' => true,
        ];

        $response = $this->post(
            '/api/suppliers',
            $data,
            $this->apiHeader()
        );
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_supplier()
    {
        $data = [
            'id' => 1,
            'name' => 'SM',
            'email' => 'sn@gmail.com',
            'phone' => '977655555215',
            'mainAddress' => 'Somewhere',
            'optionalAddress' => 'Somethere',
            'city' => 'City',
            'zipCode' => '32222',
            'country' => 'Philippines',
            'province' => 'Laguna',
            'enabled' => true,
        ];

        $response = $this->put(
            '/api/suppliers',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_suppliers()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/suppliers',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
