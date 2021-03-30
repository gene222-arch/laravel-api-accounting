<?php

namespace Tests\Feature\Http\Controllers\Api\Settings;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{

    /** test */
    public function user_can_verify_account()
    {
        $data = [
            'userId' => 1,
            'password' => 'genephillip222@gmail.com'
        ];

        $response = $this->post(
            '/api/settings/account/verify',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }


    /** @test */
    public function user_can_update_account()
    {
        $data = [
            'userId' => 1,
            'firstName' => 'Gene Pogi',
            'lastName' => 'Artista',
            'email' => 'genephillip222@gmail.com',
            'password' => 'genephillip222@gmail.com'
        ];

        $response = $this->put(
            '/api/settings/account',
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

}
