<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\CRMCompanyLog;
use App\Models\CRMCompanyNote;
use App\Models\CRMCompanyTask;
use App\Models\CRMCompanySchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class CRMCompany extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'owner',
        'email',
        'phone',
        'stage',
        'mobile',
        'website',
        'fax_number',
        'source',
        'address',
        'born_at',
        'enabled'
    ];

    protected $hidden = [
        'updated_at'
    ];
    
    /**
     * getCreatedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getCreatedAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * getBornAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getBornAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * Define a one-to-many relationship with CRMCompanyLog class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(): HasMany
    {   
        return $this->hasMany(CRMCompanyLog::class);
    }

    /**
     * Define a one-to-many relationship with CRMCompanyNote class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(): HasMany
    {   
        return $this->hasMany(CRMCompanyNote::class);
    }

    /**
     * Define a one-to-many relationship with CRMCompanySchedule class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {   
        return $this->hasMany(CRMCompanySchedule::class);
    }

    /**
     * Define a one-to-many relationship with CRMCompanyTask class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {   
        return $this->hasMany(CRMCompanyTask::class);
    }
}
