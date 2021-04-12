<?php

namespace Tests\Feature\Http\Controllers\Api\HumanResource\Payroll\PayCalendar;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayCalendarsControllerTest extends TestCase
{

    /** @test */
    public function user_can_view_any_pay_calendars()
    {
        $response = $this->get(
            '/api/human-resources/payrolls/pay-calendars',
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_pay_calendar()
    {
        $id = 1;

        $response = $this->get(
            "/api/human-resources/payrolls/pay-calendars/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_pay_calendar()
    {
        $data = [
            'name' => 'February payroll',
            'type' => 'Weekly',
            'employee_ids' => [
                1,
                2
            ]
        ];

        $response = $this->post(
            '/api/human-resources/payrolls/pay-calendars',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_pay_calendar()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'name' => 'March payroll',
            'type' => 'Weekly',
            'employee_ids' => [
                1,
            ]
        ];

        $response = $this->put(
            "/api/human-resources/payrolls/pay-calendars/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_pay_calendars()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/human-resources/payrolls/pay-calendars',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
