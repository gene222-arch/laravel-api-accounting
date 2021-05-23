<?php

namespace Tests\Feature\Http\Controllers\Api\Settings\DefaultSettings;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DefaultSettingsControllerTest extends TestCase
{

    /** @test */
    public function user_can_view_default_settings()
    {
        $response = $this->get(
            "/api/settings/default-settings",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_default_settings()
    {
        $data = [];

        $response = $this->put(
            "/api/settings/default-settings",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

}
