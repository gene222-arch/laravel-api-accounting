<?php

namespace Tests\Feature\Http\Controllers\Api\InventoryManagement\Warehouse;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WarehousesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_warehouses()
    {
        $response = $this->get(
            '/api/inventory-management/warehouses',
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_warehouse()
    {
        $id = 4;

        $response = $this->get(
            "/api/inventory-management/warehouses/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_warehouse()
    {
        $data = [
            'name' => 'Warehouse 2',
            'email' => 'warehouse2@mail.com',
            'phone'=> '22222222',
            'address' => 'Somewhre',
            'defaultWarehouse' => false,
            'enabled' => false,
            'stocks' => [
                [
                    'stock_id' => 1,
                ]
            ]
        ];

        $response = $this->post(
            '/api/inventory-management/warehouses',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_warehouse()
    {
        $data = [
            'id' => 4,
            'name' => 'Main warehouse',
            'email' => 'main@mail.com',
            'phone'=> '111111111',
            'address' => 'Somewhre',
            'defaultWarehouse' => false,
            'enabled' => false,
            'stocks' => [
                [
                    'stock_id' => 1,
                ]
            ]
        ];

        $response = $this->put(
            '/api/inventory-management/warehouses',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_warehouses()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/inventory-management/warehouses',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
