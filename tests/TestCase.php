<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->actingAs(User::first(), 'api');
        $this->withoutExceptionHandling();
    }


    protected function apiHeader()
    {
        return [
            'Accept' => 'application/json'
        ];
    }

    /**
     * Expected JSON response from the request
     * 
     * @return array
     */
    protected function jsonStructure()
    {
        return [
            'status',
            'message',
            'data'
        ];
    }


    /**
     * 
     * @param [type] $response
     * @param integer @code
     * @return void
     */
    protected function assertResponse($response, int $code = 200)
    {
        $response
            ->assertStatus($code)
            ->assertJsonStructure($this->jsonStructure());
    }

}
