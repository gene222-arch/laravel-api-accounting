<?php

namespace Tests\Feature\Http\Controllers\Api\Item\Item;

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
            '/api/item/items',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_item()
    {
        $id = 2;

        $response = $this->get(
            "/api/item/items/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_item()
    {
        $data = [
            'item' => [
                'category_id' => 1,
                'sku' => 'AAAAAAAA',
                'barcode' => 'AAAAAAAAA',
                'name' => 'Bag',
                'description' => 'two',
                'price' => 5.00,
                'cost' => 10.00,
                'sold_by' => 'each',
                'is_for_sale' => true,
                'image' => ''
            ],
            'stock' => [
                'vendor_id' => 1,
                'in_stock' => 1,
                'minimum_stock' => 10,
            ],
            'taxes' => [],
            'track_stock' => true,
        ];

        $response = $this->post(
            '/api/item/items',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_item()
    {
        $id = 2;

        $data = [
            'id' => 2,
            'item' => [
                'category_id' => 1,
                'sku' => 'CCCCCCCC',
                'barcode' => 'CCCCCCCCC',
                'name' => 'New Bag',
                'description' => 'item two',
                'price' => 5.00,
                'cost' => 10.00,
                'sold_by' => 'each',
                'is_for_sale' => true,
                'image' => ''
            ],
            'stock' => [
                'vendor_id' => 1,
                'in_stock' => 1,
                'minimum_stock' => 10,
            ],
            'taxes' => [
                1
            ],
            'track_stock' => true,
        ];


        $response = $this->put(
            "/api/item/items/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_upload_item_image()
    {
        Storage::fake('avatars');

        $image = UploadedFile::fake()->create('document.png');

        $data = [
            'image' => $image
        ];

        $response = $this->post(
            '/api/item/items/upload',
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
                5
            ]
        ];

        $response = $this->delete(
            '/api/item/items',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
