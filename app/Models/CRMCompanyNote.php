<?php

namespace App\Models;

use App\Models\CRMCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CRMCompanyNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'crm_company_id',
        'note'
    ];
    
    /**
     * Define an inverse one-to-one or many relationship with CRMCompany class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crmCompany(): BelongsTo
    {
        return $this->belongsTo(CRMCompany::class);
    }
}
