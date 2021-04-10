<?php

namespace App\Http\Controllers\Api\DoubleEntry\JournalEntry;

use App\Models\JournalEntry;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoubleEntry\JournalEntry\StoreRequest;
use App\Http\Requests\DoubleEntry\JournalEntry\DeleteRequest;
use App\Http\Requests\DoubleEntry\JournalEntry\UpdateRequest;

class JournalEntriesController extends Controller
{
    use ApiResponser;

    private JournalEntry $journalEntry;
    
    public function __construct(JournalEntry $journalEntry)
    {
        $this->journalEntry = $journalEntry;
        $this->middleware(['auth:api', 'permission:Manage Journal Entries']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->journalEntry->getAllJournalEntries();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $result = $this->journalEntry->createJournalEntry(
            $request->date,
            $request->reference,
            $request->description,
            $request->items
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Journal entry created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->journalEntry->getJournalEntryById($id);

        return !$result
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $result = $this->journalEntry->updateJournalEntry(
            $request->id,
            $request->date,
            $request->reference,
            $request->description,
            $request->items
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Journal entry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->journalEntry->deleteJournalEntries($request->ids);

        return $this->success(null, 'Journal entry  or entries deleted successfully.');
    }
}
