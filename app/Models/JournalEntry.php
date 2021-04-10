<?php

namespace App\Models;

use App\Traits\DoubleEntry\JournalEntry\JournalEntriesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JournalEntry extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use JournalEntriesServices;
    
    protected $fillable = [
        'date',
        'reference',
        'description'
    ];

    /**
     * Define a many-to-many relationship with Item class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'journal_entry_details')
            ->withPivot([
                'chart_of_account_id',
                'debit',
                'credit'
            ]);
    }

    /**
     * Define a many-to-many relationship with Chart Of Account class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function chartOfAccounts(): BelongsToMany
    {
        return $this->belongsToMany(ChartOfAccount::class, 'journal_entry_details')
            ->withPivot([
                'item_id',
                'debit',
                'credit'
            ]);
    }
}
