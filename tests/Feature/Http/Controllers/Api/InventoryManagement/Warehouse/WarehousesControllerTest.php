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

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_warehouse()
    {
        $id = 1;

        $response = $this->get(
            "/api/inventory-management/warehouses/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** @test */
    public function user_can_create_warehouse()
    {
        $data = [
            'name' => 'Warehouse 2',
            'email' => 'warehouse2@mail.com',
            'phone'=> '2222222222',
            'address' => 'Somewhre',
            'defaultWarehouse' => false,
            'enabled' => false,
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
            'id' => 2,
            'name' => 'Warehouse 2',
            'email' => 'warehouse2@mail.com',
            'phone'=> '2222222222',
            'address' => 'Somewhre',
            'defaultWarehouse' => false,
            'enabled' => false,
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
