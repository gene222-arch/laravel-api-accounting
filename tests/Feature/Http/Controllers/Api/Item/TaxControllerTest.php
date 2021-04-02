<?php

namespace Tests\Feature\Http\Controllers\Api\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaxControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_taxes()
    {
        $response = $this->get(
            '/api/taxes',
            $this->apiHeader()
        );
  
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_tax()
    {
        $id = 1;

        $response = $this->get(
            "/api/taxes/${id}",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_tax()
    {
        $data = [
            'name' => 'Income Tax',
            'rate' => 20.5,
            'type' => 'Normal',
            'enabled' => true
        ];

        $response = $this->post(
            '/api/taxes',
            $data,
            $this->apiHeader()
        );
           
        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_tax()
    {
        $data = [
            'id' => 12,
            'name' => 'Sales Tax',
            'rate' => 5.5,
            'type' => 'Normal',
            'enabled' => true
        ];

        $response = $this->put(
            "/api/taxes",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_taxes()
    {
        $data = [
            'ids' => [
                1,
                2
            ]
        ];

        $response = $this->delete(
            '/api/taxes',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}