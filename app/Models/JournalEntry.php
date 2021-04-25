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
     * Define a many-to-many relationship with ChartOfAccount class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function details(): BelongsToMany
    {
        return $this->belongsToMany(ChartOfAccount::class, 'journal_entry_details', )
            ->withPivot([
                'debit',
                'credit'
            ]);
    }
}
