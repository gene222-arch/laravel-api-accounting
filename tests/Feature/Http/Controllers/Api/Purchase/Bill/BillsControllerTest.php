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
        $id = 1;

        $response = $this->get(
            "/api/purchases/bills/${id}",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_bill()
    {
        $data = [
            'vendorId' => 1,
            'billNumber' => 'BILL-00002',
            'orderNo' => 2,
            'date' => '2021-05-03',
            'dueDate' => '2021-06-03',
            'items' => [
                [
                    'item_id' => 1,
                    'discount_id' => null,
                    'item' => 'Guitar',
                    'price' => 5.00,
                    'quantity' => 1,
                    'amount' => 25.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'paymentDetail' => [
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

    /** test */
    public function user_can_mark_bill_as_paid()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'accountId' => 2,
            'currencyId' => 1,
            'paymentMethodId' => 1,
            'expenseCategoryId' => 1,
            'date' => '2021-05-06',
            'amount' => 20.00,
        ];

        $response = $this->post(
            "/api/purchases/bills/${id}/mark-as-paid",
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_mail_vendor()
    {
        $bill = 3;
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
        $data = [
            'id' => 1,
            'accountId' => 2,
            'currencyId' => 1,
            'paymentMethodId' => 1,
            'expenseCategoryId' => 1,
            'date' => '2021-05-06',
            'amount' => 20.00,
        ];

        $response = $this->post(
            '/api/purchases/bills/payment',
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_bill()
    {
        $data = [
            'id' => 1,
            'vendorId' => 1,
            'billNumber' => 'BILL-00001',
            'orderNo' => 1,
            'date' => '2021-05-03',
            'dueDate' => '2021-06-03',
            'items' => [
                [
                    'item_id' => 1,
                    'discount_id' => null,
                    'item' => 'Guitar',
                    'price' => 5.00,
                    'quantity' => 1,
                    'amount' => 25.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'paymentDetail' => [
                'total_discounts' => 0.00,
                'total_taxes' => 20.00,
                'sub_total' => 45.00,
                'total' => 65.00,
                'amount_due' => 65.00
            ]
        ];

        $response = $this->put(
            '/api/purchases/bills',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_cancel_bill()
    {
        $id = 1;

        $data = [];

        $response = $this->put(
            "/api/purchases/bills/${id}",
            $data,
            $this->apiHeader()
        );

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
