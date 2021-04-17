<?php

namespace App\Http\Controllers\Api\DoubleEntry\JournalEntry;

use App\Models\JournalEntry;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoubleEntry\JournalEntry\DeleteRequest;
use App\Http\Requests\DoubleEntry\JournalEntry\UpdateStoreRequest;

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
        setSqlModeEmpty();

        $result = $this->journalEntry
            ->selectRaw('
                DATE_FORMAT(journal_entries.date, "%d %M %Y") as date,
                SUM(journal_entry_details.debit) + SUM(journal_entry_details.credit) as amount,
                journal_entries.description,
                journal_entries.reference
            ')
            ->join('journal_entry_details', 'journal_entry_details.journal_entry_id', '=', 'journal_entries.id')
            ->groupBy('journal_entries.id')
            ->latest()
            ->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UpdateStoreRequest $request)
    {
        $result = $this->journalEntry->createJournalEntry(
            $request->except('details'),
            $request->details
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Journal entry created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param JournalEntry $journalEntry
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(JournalEntry $journalEntry)
    {
        $journalEntry = $journalEntry->with('details')->first();

        return !$journalEntry
            ? $this->noContent()
            : $this->success($journalEntry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @param JournalEntry $journalEntry
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStoreRequest $request, JournalEntry $journalEntry)
    {
        $result = $this->journalEntry->updateJournalEntry(
            $journalEntry,
            $request->except('details'),
            $request->details
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
        $this->journalEntry->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Journal entry  or entries deleted successfully.');
    }
}
