<?php

namespace Tests\Feature\Http\Controllers\Api\Sales\Invoice;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstimateInvoicesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_estimate_invoices()
    {
        $response = $this->get(
            '/api/sales/estimate-invoices',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_estimate_invoice()
    {
        $id = 2;

        $response = $this->get(
            "/api/sales/estimate-invoices/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_estimate_invoice()
    {
        $data = [
            'customer_id' => 1,
            'currency_id' => 1,
            'income_category_id' => 1,
            'estimate_number' => 'EST-00002',
            'estimated_at' => '2021-05-03',
            'expired_at' => '2021-06-03',
            'enable_reminder' => false,
            'items' => [
                [
                    'item_id' => 2,
                    'discount_id' => null,
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
            ]
        ];

        $response = $this->post(
            '/api/sales/estimate-invoices',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** @test */
    public function user_can_mail_customer()
    {
        $estimate_number = 1;
        $customer = 1;
        $data = [
            'subject' => 'Your Estimate Invoice Receipt',
            'greeting' => 'Good day sir,',
            'note' => 'We hope you continue using our services.',
            'footer' => ''
        ];

        $response = $this->post(
            "/api/sales/estimate-invoices/${estimate_number}/customers/${customer}/mail",
            $data,
            $this->apiHeader()
        ); 

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_mark_estimate_invoice_as_approved()
    {
        $id = 1;

        $response = $this->put(
            "/api/sales/estimate-invoices/${id}/mark-as-approved",
            [],
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_mark_estimate_invoice_as_refused()
    {
        $id = 1;

        $response = $this->put(
            "/api/sales/estimate-invoices/${id}/mark-as-refused",
            [],
            $this->apiHeader()
        ); 

        $this->assertResponse($response);
    }
    
    /** test */
    public function user_can_update_estimate_invoice()
    {
        $id = 2;

        $data = [
            'id' => 2,
            'customer_id' => 1,
            'currency_id' => 1,
            'income_category_id' => 1,
            'estimate_number' => 'EST-00004',
            'estimated_at' => '2021-05-03',
            'expired_at' => '2021-06-03',
            'enable_reminder' => true,
            'items' => [
                [
                    'item_id' => 2,
                    'discount_id' => null,
                    'item' => 'Dawk',
                    'price' => 5.00,
                    'quantity' => 1,
                    'amount' => 255.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'payment_details' => [
                'total_discounts' => 0.00,
                'total_taxes' => 40.00,
                'sub_total' => 50.00,
                'total' => 130.00,
            ]
        ];


        $response = $this->put(
            "/api/sales/estimate-invoices/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_estimate_invoices()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/sales/estimate-invoices',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
