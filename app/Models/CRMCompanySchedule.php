<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\CRMCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CRMCompanySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'crm_company_id',
        'user_id',
        'name',
        'log',
        'started_at',
        'updated_at',
        'time_started',
        'time_ended',
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /**
     * getStartedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getStartedAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * getEndedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getEndedAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
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
