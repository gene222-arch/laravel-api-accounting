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
        $id = 2;

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
            'customer_id' => 1,
            'currency_id' => 1,
            'income_category_id' => 1,
            'invoice_number' => 'INV-00002',
            'order_no' => 2,
            'date' => '2021-05-03',
            'due_date' => '2021-06-03',
            'recurring' => 'No',
            'items' => [
                [
                    'item_id' => 2,
                    'discount_id' => null,
                    'tax_id' => null,
                    'item' => 'Dawk',
                    'price' => 5.00,
                    'quantity' => 1,
                    'amount' => 25.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'payment_details' => [
                'total_discounts' => 0.00,
                'total_taxes' => 40.00,
                'sub_total' => 90.00,
                'total' => 130.00,
                'amount_due' => 130.00
            ]
        ];

        $response = $this->post(
            '/api/sales/invoices',
            $data,
            $this->apiHeader()
        ); 

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
            "/api/sales/invoices/${invoice}/customers/${customer}/mail",
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_mark_invoice_as_paid()
    {
        $id = 3;

        $data = [
            'account_id' => 1,
            'payment_method_id' => 1,
            'amount' => 55.00,
        ];

        $response = $this->put(
            "/api/sales/invoices/${id}/mark-as-paid",
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_invoice_payment()
    {
        $id = 3;

        $data = [
            'id' => 3,
            'account_id' => 1,
            'payment_method_id' => 1,
            'date' => '2021-05-06',
            'amount' => 10.00,
        ];

        $response = $this->post(
            "/api/sales/invoices/${id}/payment",
            $data,
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_invoice()
    {
        $id = 3;

        $data = [
            'id' => 3,
            'customer_id' => 1,
            'currency_id' => 1,
            'income_category_id' => 2,
            'invoice_number' => 'INV-00003',
            'order_no' => 3,
            'date' => '2021-05-03',
            'due_date' => '2021-06-03',
            'recurring' => 'No',
            'items' => [
                [
                    'item_id' => 2,
                    'discount_id' => null,
                    'tax_id' => null,
                    'item' => 'Item two',
                    'price' => 5.00,
                    'quantity' => 5,
                    'amount' => 25.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'payment_details' => [
                'total_discounts' => 0.00,
                'total_taxes' => 40.00,
                'sub_total' => 50.00,
                'total' => 90.00,
                'amount_due' => 65.00
            ]
        ];

        $response = $this->put(
            "/api/sales/invoices/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_cancel_an_invoice()
    {
        $id = 2;

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
