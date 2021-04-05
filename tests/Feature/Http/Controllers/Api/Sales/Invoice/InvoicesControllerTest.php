<?php

namespace Tests\Feature\Http\Controllers\Api\Sales\Invoice;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoicesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_invoices()
    {
        $response = $this->get(
            '/api/sales/invoices',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_invoice()
    {
        $id = 1;

        $response = $this->get(
            "/api/sales/invoices/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_invoice()
    {
        $data = [
            'customerId' => 1,
            'invoiceNumber' => 'INV-00002',
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
            'paymentDetails' => [
                'total_discounts' => 0.00,
                'total_taxes' => 20.00,
                'sub_total' => 45.00,
                'total' => 65.00,
                'amount_due' => 65.00
            ]
        ];

        $response = $this->post(
            '/api/sales/invoices',
            $data,
            $this->apiHeader()
        ); 

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_mail_customer()
    {
        $invoice = 3;
        $customer = 1;
        $data = [
            'subject' => 'Your Invoice Receipt',
            'greeting' => 'Good day sir,',
            'note' => 'We hope you continue using our services.',
            'footer' => ''
        ];

        $response = $this->post(
            "/api/sales/invoices/${invoice}/customer/${customer}/mail",
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_mark_invoice_as_paid()
    {
        $id = 4;

        $data = [
            'amount' => 65.00
        ];

        $response = $this->post(
            "/api/sales/invoices/${id}/mark-as-paid",
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** @test */
    public function user_can_create_invoice_payment()
    {
        $data = [
            'id' => 1,
            'accountId' => 2,
            'currencyId' => 1,
            'paymentMethodId' => 1,
            'date' => '2021-05-06',
            'amount' => 20.00,
        ];

        $response = $this->post(
            '/api/sales/invoices/payment',
            $data,
            $this->apiHeader()
        ); 

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_invoice()
    {
        $data = [
            'id' => 2,
            'customerId' => 1,
            'invoiceNumber' => 'INV-00002',
            'orderNo' => 2,
            'date' => '2021-05-03',
            'dueDate' => '2021-06-03',
            'items' => [
                [
                    'item_id' => 1,
                    'discount_id' => null,
                    'item' => 'Item one',
                    'price' => 5.00,
                    'quantity' => 5,
                    'amount' => 25.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
                [
                    'item_id' => 2,
                    'discount_id' => null,
                    'item' => 'Item two',
                    'price' => 5.00,
                    'quantity' => 5,
                    'amount' => 25.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'paymentDetails' => [
                'total_discounts' => 0.00,
                'total_taxes' => 40.00,
                'sub_total' => 50.00,
                'total' => 90.00,
                'amount_due' => 65.00
            ]
        ];

        $response = $this->put(
            '/api/sales/invoices',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_cancel_an_invoice()
    {
        $id = 1;

        $data = [];

        $response = $this->put(
            "/api/sales/invoices/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_invoices()
    {
        $data = [
            'ids' => [
                5
            ]
        ];

        $response = $this->delete(
            '/api/sales/invoices',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
