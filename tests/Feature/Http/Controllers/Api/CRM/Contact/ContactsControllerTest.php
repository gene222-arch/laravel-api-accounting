<?php

namespace Tests\Feature\Http\Controllers\Api\CRM\Contact;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_contacts()
    {
        $response = $this->get(
            '/api/crm/contacts',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_contact()
    {
        $id = 1;

        $response = $this->get(
            "/api/crm/contacts/${id}",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_contact()
    {
        $data = [
            'name' => 'Johnny',
            'owner' => 'Jun',
            'email' => 'jopnyy@yahoo.com',
            'phone' => '1111111111',
            'stage' => 'Customer',
            'mobile' => '1111111121',
            'website' => 'test',
            'fax_number' => '12321231123',
            'source' => 'Gege',
            'address' => 'Gege',
            'born_at' => '2021-05-05'
        ];

        $response = $this->post(
            '/api/crm/contacts',
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_contact()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'name' => 'Johnny',
            'owner' => 'Jun',
            'email' => 'jopnyy@yahoo.com',
            'phone' => '1111111111',
            'stage' => 'Customer',
            'mobile' => '1111111121',
            'website' => 'test',
            'fax_number' => '12321231123',
            'source' => 'Gege',
            'address' => 'Gege',
            'born_at' => '2021-05-05'
        ];

        $response = $this->put(
            "/api/crm/contacts/${id}",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_contacts()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/crm/contacts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
