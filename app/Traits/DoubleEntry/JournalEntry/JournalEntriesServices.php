<?php

namespace App\Traits\DoubleEntry\JournalEntry;

use App\Models\JournalEntry;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait JournalEntriesServices
{
    
    /**
     * Get latest records of JournalEntries
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllJournalEntries (): Collection
    {
        return JournalEntry::with('items')
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of journal entry via id
     *
     * @param  int $id
     * @return JournalEntry|null
     */
    public function getJournalEntryById (int $id): JournalEntry|null
    {
        return JournalEntry::where('id', $id)
            ->with('items')
            ->first();
    }
    
    /**
     * Create a new record of journal entry
     *
     * @param  string $date
     * @param  string|null $reference
     * @param  string|null $description
     * @param  array $items
     * @return mixed
     */
    public function createJournalEntry (string $date, ?string $reference, ?string $description, array $items): mixed
    {
        try {
            DB::transaction(function () use ($date, $reference, $description, $items)
            {
                $journalEntry = JournalEntry::create([
                    'date' => $date,
                    'reference' => $reference,
                    'description' => $description
                ]);

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
     * @param  integer $id
     * @param  string $date
     * @param  string|null $reference
     * @param  string|null $description
     * @param  array $items
     * @return mixed
     */
    public function updateJournalEntry (int $id, string $date, ?string $reference, ?string $description, array $items): mixed
    {
        try {
            DB::transaction(function () use ($id, $date, $reference, $description, $items)
            {
                $journalEntry = JournalEntry::find($id);

                $journalEntry->update([
                    'date' => $date,
                    'reference' => $reference,
                    'description' => $description
                ]);

                $journalEntry->items()->sync($items);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Delete one or multiple records of journal entries
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteJournalEntries (array $ids): bool
    {
        return JournalEntry::whereIn('id', $ids)->delete();
    }
}