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
        $id = 1;

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
                'categoryId' => 1,
                'sku' => 'AAAAAAAA',
                'barcode' => 'AAA',
                'name' => 'Item one',
                'description' => 'Some itme one',
                'price' => 5.00,
                'cost' => 10.00,
                'soldBy' => 'each',
                'isForSale' => true,
                'image' => '',
                'taxes' => []
            ],
            'stock' => [
                'supplierId' => 1,
                'inStock' => 1,
                'minimumStock' => 10,
            ],
            'trackStock' => false,
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
        $data = [
            'item' => [
                'id' => 1,
                'categoryId' => 1,
                'sku' => 'AAAAAAAA',
                'barcode' => 'AAA',
                'name' => 'Item one',
                'description' => 'Some itme one',
                'price' => 5.00,
                'cost' => 10.00,
                'soldBy' => 'each',
                'isForSale' => true,
                'image' => '',
                'taxes' => [
                    1
                ]
            ],
            'stock' => [
                'supplierId' => 1,
                'warehouseId' => 1,
                'inStock' => 12,
                'minimumStock' => 10,
            ],
            'trackStock' => true,
        ];


        $response = $this->put(
            '/api/item/items',
            $data,
            $this->apiHeader()
        );
 
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
                4
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
