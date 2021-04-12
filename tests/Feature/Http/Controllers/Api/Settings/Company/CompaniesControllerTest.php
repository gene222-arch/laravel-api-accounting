<?php

namespace Tests\Feature\Http\Controllers\Api\Settings\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompaniesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_company()
    {
        $id = 1;

        $response = $this->get(
            "/api/settings/company/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_company()
    {
        $data = [
            'name' => 'CCC',
            'email' => 'CCC@company.com',
            'tax_number' => '22222122222',
            'phone' => '22222222122',
        ];

        $response = $this->post(
            '/api/settings/company',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_company()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'name' => 'ABCDEFG',
            'email' => 'test@company.com',
            'tax_number' => '111111111',
            'phone' => '11111111111',
        ];

        $response = $this->put(
            "/api/settings/company/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
