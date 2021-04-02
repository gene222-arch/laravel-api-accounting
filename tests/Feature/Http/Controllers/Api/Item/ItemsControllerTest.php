<?php

namespace Tests\Feature\Http\Controllers\Api\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_items()
    {
        $response = $this->get(
            '/api/items',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_item()
    {
        $id = 1;

        $response = $this->get(
            "/api/items/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_item()
    {
        $data = [
            'categoryId' => 2,
            'sku' => 'BBBBBBBB',
            'barcode' => 'BBB',
            'name' => 'Item two',
            'price' => 0.00,
            'cost' => 10.00,
            'soldBy' => 'each',
            'isForSale' => true
        ];

        $response = $this->post(
            '/api/items',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_item()
    {
        $data = [
            'id' => 2,
            'categoryId' => 2,
            'sku' => 'BBBBBBBB',
            'barcode' => 'BBB',
            'name' => 'Item two',
            'price' => 0.00,
            'cost' => 10.00,
            'soldBy' => 'each',
            'isForSale' => true
        ];

        $response = $this->put(
            '/api/items',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** @test */
    public function user_can_upload_item_image()
    {
        Storage::fake('avatars');

        $image = UploadedFile::fake()->create('document.pdf');

        $data = [
            'image' => $image
        ];

        $response = $this->post(
            '/api/items/upload',
            $data,
            $this->apiHeader()
        );
  
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_items()
    {
        $data = [
            'ids' => [
                2
            ]
        ];

        $response = $this->delete(
            '/api/items',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
