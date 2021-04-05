<?php

namespace Tests\Feature\Http\Controllers\Api\Item\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_categories()
    {
        $response = $this->get(
            '/api/item/categories',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_category()
    {
        $id = 1;

        $response = $this->get(
            "/api/item/categories/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_category()
    {
        $data = [
            'name' => 'Guitar',
            'hexCode' => '#000002',
            'enabled' => true,
        ];

        $response = $this->post(
            '/api/item/categories',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_category()
    {
        $data = [
            'id' => 2,
            'name' => 'Guitar',
            'hexCode' => '#000002',
            'enabled' => true,
        ];

        $response = $this->put(
            '/api/item/categories',
            $data,
            $this->apiHeader()
        );


        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_categories()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/item/categories',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
