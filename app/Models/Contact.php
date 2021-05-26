<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\ContactLog;
use App\Models\ContactNote;
use App\Models\ContactTask;
use App\Models\ContactSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
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
     * Define a one-to-many relationship with ContactLog class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(): HasMany
    {   
        return $this->hasMany(ContactLog::class);
    }

    /**
     * Define a one-to-many relationship with ContactNote class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(): HasMany
    {   
        return $this->hasMany(ContactNote::class);
    }

    /**
     * Define a one-to-many relationship with ContactSchedule class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {   
        return $this->hasMany(ContactSchedule::class);
    }

    /**
     * Define a one-to-many relationship with ContactTask class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {   
        return $this->hasMany(ContactTask::class);
    }
}
