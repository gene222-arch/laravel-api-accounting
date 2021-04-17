<?php

namespace Tests\Feature\Http\Controllers\Api\DoubleEntry\JournalEntry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JournalEntriesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_journal_entries()
    {
        $response = $this->get(
            '/api/double-entry/journal-entries',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_journal_entry()
    {
        $id = 3;

        $response = $this->get(
            "/api/double-entry/journal-entries/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_journal_entry()
    {
        $data = [
            'date' => '2021-05-05',
            'description' => 'First journal entry',
            'details' => [
                [
                    'chart_of_account_id' => 1,
                    'debit' => 10.00,
                    'credit' => 0.00
                ]
            ]
        ];

        $response = $this->post(
            '/api/double-entry/journal-entries',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_journal_entry()
    {
        $id = 2;

        $data = [
            'date' => '2021-05-05',
            'description' => 'First journal entry',
            'details' => [
                [
                    'chart_of_account_id' => 4,
                    'debit' => 10.00,
                    'credit' => 0.00
                ],
                [
                    'chart_of_account_id' => 5,
                    'debit' => 10.00,
                    'credit' => 0.00
                ],
                [
                    'chart_of_account_id' => 6,
                    'debit' => 10.00,
                    'credit' => 0.00
                ]
            ]
        ];

        $response = $this->put(
            "/api/double-entry/journal-entries/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_journal_entries()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/double-entry/journal-entries',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
