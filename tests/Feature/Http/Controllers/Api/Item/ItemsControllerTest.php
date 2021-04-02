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
            'item' => [
                'categoryId' => 1,
                'sku' => 'AAAAAAAA',
                'barcode' => 'AAA',
                'name' => 'Item one',
                'description' => 'Some itme one',
                'price' => 5.00,
                'cost' => 10.00,
                'soldBy' => 'each',
                'isForSale' => true,
                'image' => ''
            ],
            'stock' => [
                'supplierId' => 1,
                'warehouseId' => 1,
                'inStock' => 1,
            ],
            'trackStock' => false,
        ];

        $response = $this->post(
            '/api/items',
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_item()
    {
        $data = [
            'item' => [
                'id' => 4,
                'categoryId' => 1,
                'sku' => 'AAAAAAAA',
                'barcode' => 'AAA',
                'name' => 'Item one',
                'description' => 'Some itme one',
                'price' => 5.00,
                'cost' => 10.00,
                'soldBy' => 'each',
                'isForSale' => true,
                'image' => ''
            ],
            'stock' => [
                'supplierId' => 1,
                'warehouseId' => 1,
                'inStock' => 12,
            ],
            'trackStock' => true,
        ];


        $response = $this->put(
            '/api/items',
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
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

    /** @test */
    public function user_can_delete_items()
    {
        $data = [
            'ids' => [
                4
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
