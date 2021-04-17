<?php

namespace App\Models;

use App\Models\ChartOfAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChartOfAccountType extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'description'
    ];
    
    /**
     * Define a one-to-many relationship with ChartOfAccount class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chartOfAccounts(): HasMany
    {
        return $this->hasMany(ChartOfAccount::class);
    }
}
