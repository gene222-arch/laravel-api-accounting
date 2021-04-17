<?php

namespace App\Traits\DoubleEntry\JournalEntry;

use App\Models\JournalEntry;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait JournalEntriesServices
{

    /**
     * Create a new record of journal entry
     *
     * @param  array $journalEntryDetails
     * @param  array $details
     * @return mixed
     */
    public function createJournalEntry (array $journalEntryDetails, array $details): mixed
    {
        try {
            DB::transaction(function () use ($journalEntryDetails, $details)
            {
                $journalEntry = JournalEntry::create($journalEntryDetails);

                $journalEntry->details()->attach($details);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of journal entry
     *
     * @param  JournalEntry $journalEntry
     * @param  array $journalEntryDetails
     * @param  array $details
     * @return mixed
     */
    public function updateJournalEntry (JournalEntry $journalEntry, array $journalEntryDetails, array $details): mixed
    {
        try {
            DB::transaction(function () use ($journalEntry, $journalEntryDetails, $details)
            {
                $journalEntry->update($journalEntryDetails);

                $journalEntry->details()->sync($details);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

}