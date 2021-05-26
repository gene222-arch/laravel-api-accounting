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

        dd(json_decode($response->getContent()));
        
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
    public function user_can_view_contact_note()
    {
        $id = 1;

        $response = $this->get(
            "/api/crm/contacts/${id}/notes",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_contact_schedule()
    {
        $id = 1;

        $response = $this->get(
            "/api/crm/contacts/${id}/schedules",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_contact_task()
    {
        $id = 1;

        $response = $this->get(
            "/api/crm/contacts/${id}/tasks",
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
            'email' => 'jopnyyyahoo.com',
            'phone' => '1111111111',
            'stage' => 'Customer',
            'mobile' => '1111111121',
            'website' => 'test',
            'fax_number' => '12321231123',
            'source' => 'Gege',
            'address' => 'Gege',
            'born_at' => '2021-05-05',
            'enabled' => false
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
    public function user_can_create_contact_note()
    {
        $id = 1;

        $data = [
            'contact_id' => $id,
            'note' => 'lorem ipsum test'
        ];

        $response = $this->post(
            "/api/crm/contacts/${id}/notes",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_contact_log()
    {
        $id = 1;

        $data = [
            'date' => '2021-05-05',
            'time' => '02:30:30',
            'log' => 'log',
            'description' => 'description'
        ];

        $response = $this->post(
            "/api/crm/contacts/${id}/logs",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_contact_schedule()
    {
        $id = 1;

        $data = [
            'user_id' => 1,
            'name' => 'Name',
            'log' => 'Log sched',
            'started_at' => '2021-05-05',
            'updated_at' => '2021-05-05',
            'time_started' => '02:30:30',
            'time_ended' => '02:30:30',
            'description' => 'description'
        ];

        $response = $this->post(
            "/api/crm/contacts/${id}/schedules",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_contact_task()
    {
        $id = 1;

        $data = [
            'contact_id' => 1,
            'user_id' => 1,
            'name' => 'Name',
            'started_at' => '2021-05-05',
            'time_started' => '02:30:30',
            'description' => 'description'
        ];

        $response = $this->post(
            "/api/crm/contacts/${id}/tasks",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_mail_contact()
    {
        $id = 1;

        $data = [
            'contact_id' => $id,
            'subject' => 'Subject',
            'body' => 'body'
        ];

        $response = $this->post(
            "/api/crm/contacts/${id}/mail",
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
            'email' => 'jopnyyyahoo.com',
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
    public function user_can_update_contact_note()
    {
        $id = 1;

        $data = [
            'contact_id' => $id,
            'note_id' => 1,
            'note' => 'NEW lorem ipsum test'
        ];

        $response = $this->put(
            "/api/crm/contacts/${id}/notes",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_contact_log()
    {
        $id = 1;

        $data = [
            'log_id' => 1,
            'date' => '2021-05-05',
            'time' => '02:30:30',
            'log' => 'log',
            'description' => 'NEW description'
        ];

        $response = $this->put(
            "/api/crm/contacts/${id}/logs",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_contact_schedule()
    {
        $id = 1;

        $data = [
            'schedule_id' => 1,
            'user_id' => 1,
            'name' => 'NEW Name',
            'log' => 'Log sched',
            'started_at' => '2021-05-05',
            'updated_at' => '2021-05-05',
            'time_started' => '02:30:30',
            'time_ended' => '02:30:30',
            'description' => 'description'
        ];

        $response = $this->put(
            "/api/crm/contacts/${id}/schedules",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_contact_task()
    {
        $id = 1;

        $data = [
            'task_id' => 2,
            'contact_id' => 1,
            'user_id' => 1,
            'name' => 'NEW Name',
            'started_at' => '2021-05-05',
            'time_started' => '02:30:30',
            'description' => 'description'
        ];

        $response = $this->put(
            "/api/crm/contacts/${id}/tasks",
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

    /** test */
    public function user_can_delete_contact_notes()
    {
        $id = 1;

        $data = [
            'note_ids' => [
                1
            ]
        ];

        $response = $this->delete(
            "/api/crm/contacts/${id}/notes",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_contact_logs()
    {
        $id = 1;

        $data = [
            'log_ids' => [
                1
            ]
        ];

        $response = $this->delete(
            "/api/crm/contacts/${id}/logs",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_contact_schedules()
    {
        $id = 1;

        $data = [
            'schedule_ids' => [
                1
            ]
        ];

        $response = $this->delete(
            "/api/crm/contacts/${id}/schedules",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_contact_tasks()
    {
        $id = 1;

        $data = [
            'task_ids' => [
                1
            ]
        ];

        $response = $this->delete(
            "/api/crm/contacts/${id}/tasks",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }
}
