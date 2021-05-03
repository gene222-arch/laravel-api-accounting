<?php

namespace App\Models;

use App\Jobs\QueuePasswordResetNotification;
use App\Notifications\EmailVerificationNotification;
use App\Traits\Auth\User\UsersServices;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** Libraries or Built-in */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, HasRoles;

    /** Custom */
    use UsersServices;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

        
    /**
     * Define a one-to-one relationship with Company class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }


    /**
     * Dispatch a password reset notification
     * 
     * @return void
     */
    public function sendPasswordResetNotification($token): void 
    {
        dispatch(new QueuePasswordResetNotification($this, $token))
            ->delay(now()->addSeconds(10));
    }
    
    /**
     * Send an email notification verification
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void 
    {
        $this->notify(new EmailVerificationNotification());
    }
}
