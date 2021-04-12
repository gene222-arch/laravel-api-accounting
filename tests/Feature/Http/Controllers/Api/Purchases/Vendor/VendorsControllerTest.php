<?php

namespace Tests\Feature\Http\Controllers\Api\Purchases\Vendor;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_vendors()
    {
        $response = $this->get(
            '/api/purchases/vendors',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_vendor()
    {
        $id = 1;

        $response = $this->get(
            "/api/purchases/vendors/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_vendor()
    {
        $data = [
            'currency_id' => 2,
            'name' => 'Vendor 2',
            'email' => 'genephillip2@gmail.com',
            'tax_number' => '22222',
            'phone' => '22222222222',
            'address' => 'Somewhre',
            'enabled' => true,
        ];

        $response = $this->post(
            '/api/purchases/vendors',
            $data,
            $this->apiHeader()
        );
 
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_vendor()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'currency_id' => 2,
            'name' => 'New Vendor 1',
            'email' => 'new@gmail.com',
            'tax_number' => '22223',
            'phone' => '111111111111',
            'address' => 'Somewhre',
            'enabled' => true,
        ];

        $response = $this->put(
            "/api/purchases/vendors/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_vendors()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/purchases/vendors',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
