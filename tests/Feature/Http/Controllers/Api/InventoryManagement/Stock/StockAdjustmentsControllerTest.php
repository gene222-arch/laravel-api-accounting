<?php

namespace Tests\Feature\Http\Controllers\Api\InventoryManagement\Stock;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockAdjustmentsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_stock_adjustments()
    {
        $response = $this->get(
            '/api/inventory-management/stock-adjustments',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_stock_adjustment()
    {
        $id = 5;

        $response = $this->get(
            "/api/inventory-management/stock-adjustments/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_stock_adjustment()
    {
        $data = [
            'stock_adjustment_number' => 'SA-00005',
            'reason' => 'Inventory count',
            'adjustment_details' => [
                [
                    'stock_id' => 2,
                    'item' => 'Gibson',
                    'book_quantity' => 5,
                    'quantity' => 10,
                    'physical_quantity' => 10, 
                    'unit_price' => 5.00,
                    'amount' => 50.00
                ]
            ]
        ];

        $response = $this->post(
            '/api/inventory-management/stock-adjustments',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_stock_adjustment()
    {
        $id = 3;

        $data = [
            'id' => 3,
            'stock_adjustment_number' => 'SA-00003',
            'reason' => 'Received items',
            'adjustment_details' => [
                [
                    'stock_id' => 2,
                    'item' => 'Gibson',
                    'book_quantity' => 5,
                    'quantity' => 10,
                    'physical_quantity' => 15, 
                    'unit_price' => 5.00,
                    'amount' => 50.00
                ]
            ]
        ];

        $response = $this->put(
            "/api/inventory-management/stock-adjustments/${id}",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_stock_adjustments()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/inventory-management/stock-adjustments',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
