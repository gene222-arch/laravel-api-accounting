<?php

namespace Tests\Feature\Http\Controllers\Api\Purchase\Bill;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BillsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_bills()
    {
        $response = $this->get(
            '/api/purchases/bills',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_bill()
    {
        $id = 3;

        $response = $this->get(
            "/api/purchases/bills/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_bill()
    {
        $data = [
            'currency_id' => 1,
            'expense_category_id' => 1,
            'vendor_id' => 1,
            'bill_number' => 'BILL-00005',
            'order_no' => 5,
            'date' => '2021-05-03',
            'due_date' => '2021-06-03',
            'recurring' => 'No',
            'items' => [
                [
                    'item_id' => 2,
                    'discount_id' => null,
                    'tax_id' => null,
                    'item' => 'Guitar',
                    'price' => 5.00,
                    'quantity' => 1,
                    'amount' => 25.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'payment_details' => [
                'total_discounts' => 0.00,
                'total_taxes' => 20.00,
                'sub_total' => 45.00,
                'total' => 65.00,
                'amount_due' => 65.00
            ]
        ];

        $response = $this->post(
            '/api/purchases/bills',
            $data,
            $this->apiHeader()
        );
 
        $this->assertResponse($response);
    }

    /**test */
    public function user_can_mark_bill_as_paid()
    {
        $id = 7;

        $data = [
            'account_id' => 1,
            'currency_id' => 1,
            'payment_method_id' => 1,
            'expense_category_id' => 1,
            'amount' => 65.00,
        ];

        $response = $this->post(
            "/api/purchases/bills/${id}/mark-as-paid",
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /**test */
    public function user_can_mark_bill_as_received()
    {
        $id = 7;

        $response = $this->put(
            "/api/purchases/bills/${id}/mark-as-received",
            [],
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_mail_vendor()
    {
        $bill = 1;
        $vendor = 1;
        $data = [
            'subject' => 'Bill Receipt',
            'greeting' => 'Good day sir,',
            'note' => 'We hope you continue using our services.',
            'footer' => ''
        ];

        $response = $this->post(
            "/api/purchases/bills/${bill}/vendors/${vendor}/mail",
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_bill_payment()
    {
        $id = 3;

        $data = [
            'id' => 3,
            'account_id' => 1,
            'currency_id' => 1,
            'payment_method_id' => 1,
            'expense_category_id' => 1,
            'date' => '2021-05-06',
            'amount' => 20.00,
        ];

        $response = $this->post(
            "/api/purchases/bills/${id}/payment",
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_bill()
    {
        $id = 3;

        $data = [
            'id' => 3,
            'vendor_id' => 1,
            'bill_number' => 'BILL-00003',
            'order_no' => 1,
            'date' => '2021-05-03',
            'due_date' => '2021-06-03',
            'recurring' => 'No',
            'items' => [
                [
                    'item_id' => 2,
                    'discount_id' => null,
                    'tax_id' => null,
                    'item' => 'Guitar',
                    'price' => 5.00,
                    'quantity' => 1,
                    'amount' => 25.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'payment_details' => [
                'total_discounts' => 0.00,
                'total_taxes' => 20.00,
                'sub_total' => 45.00,
                'total' => 65.00,
                'amount_due' => 65.00
            ]
        ];

        $response = $this->put(
            "/api/purchases/bills/${id}",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_cancel_bill()
    {
        $id = 1;

        $data = [];

        $response = $this->put(
            "/api/purchases/bills/${id}/cancel-order",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_bills()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/purchases/bills',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
