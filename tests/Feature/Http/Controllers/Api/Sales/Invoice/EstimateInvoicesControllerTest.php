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
        $id = 1;

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
            'customerId' => 1,
            'currencyId' => 1,
            'estimateNumber' => 'EST-00002',
            'estimatedAt' => '2021-05-03',
            'expiredAt' => '2021-06-03',
            'enableReminder' => false,
            'items' => [
                [
                    'item_id' => 1,
                    'discount_id' => null,
                    'item' => 'Dawk',
                    'price' => 5.00,
                    'quantity' => 1,
                    'amount' => 25.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'paymentDetail' => [
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

    /** test */
    public function user_can_mail_customer()
    {
        $estimateNumber = 3;
        $customer = 1;
        $data = [
            'subject' => 'Your Estimate Invoice Receipt',
            'greeting' => 'Good day sir,',
            'note' => 'We hope you continue using our services.',
            'footer' => ''
        ];

        $response = $this->post(
            "/api/sales/estimate-invoices/${estimateNumber}/customers/${customer}/mail",
            $data,
            $this->apiHeader()
        ); 

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
        $data = [
            'id' => 1,
            'customerId' => 1,
            'currencyId' => 1,
            'estimateNumber' => 'EST-00004',
            'estimatedAt' => '2021-05-03',
            'expiredAt' => '2021-06-03',
            'enableReminder' => true,
            'items' => [
                [
                    'item_id' => 1,
                    'discount_id' => null,
                    'item' => 'Dawk',
                    'price' => 5.00,
                    'quantity' => 1,
                    'amount' => 255.00,
                    'discount' => 0.00,
                    'tax' => 0.00
                ],
            ],
            'paymentDetail' => [
                'total_discounts' => 0.00,
                'total_taxes' => 40.00,
                'sub_total' => 50.00,
                'total' => 130.00,
            ]
        ];


        $response = $this->put(
            '/api/sales/estimate-invoices',
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
