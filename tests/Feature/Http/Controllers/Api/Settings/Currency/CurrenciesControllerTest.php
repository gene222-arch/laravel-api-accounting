<?php

namespace Tests\Feature\Http\Controllers\Api\Settings\Currency;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrenciesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_currencies()
    {
        $response = $this->get(
            '/api/settings/currencies',
            $this->apiHeader()
        );


        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_currency()
    {
        $id = 1;

        $response = $this->get(
            "/api/settings/currencies/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_currency()
    {
        $data = [
            'name' => 'Philippines Peso',
            'code' => 'Pes',
            'enabled' => true
        ];

        $response = $this->post(
            '/api/settings/currencies',
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_currency()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'name' => 'US Dollar',
            'code' => 'USD',
            'enabled' => true
        ];

        $response = $this->put(
            "/api/settings/currencies/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_currencies()
    {
        $data = [
            'ids' => [
                2
            ]
        ];

        $response = $this->delete(
            '/api/settings/currencies',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
