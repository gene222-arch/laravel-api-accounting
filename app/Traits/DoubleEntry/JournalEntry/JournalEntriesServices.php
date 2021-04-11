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
     * @param  array $items
     * @return mixed
     */
    public function createJournalEntry (array $journalEntryDetails, array $items): mixed
    {
        try {
            DB::transaction(function () use ($journalEntryDetails, $items)
            {
                $journalEntry = JournalEntry::create($journalEntryDetails);

                $journalEntry->items()->attach($items);
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
     * @param  array $items
     * @return mixed
     */
    public function updateJournalEntry (JournalEntry $journalEntry, array $journalEntryDetails, array $items): mixed
    {
        try {
            DB::transaction(function () use ($journalEntry, $journalEntryDetails, $items)
            {
                $journalEntry->update($journalEntryDetails);

                $journalEntry->items()->sync($items);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

}