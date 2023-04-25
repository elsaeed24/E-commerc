<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable /*implements MustVerifyEmail*/
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'device_token',
        'mobile',
        'provider',
        'provider_id',
        'provider_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




   // one user has one profile

    public function profile()
    {
        return $this->hasOne(Profile::class,'user_id','id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function routeNotificationForFcm($notification = null)
    {
        return $this->deviceTokens()->pluck('token')->toArray();
    }

    public function setProviderTokenAttribute($value)
    {
        $this->attributes['provider_token'] = Crypt::encryptString($value);
    }

    public function getProviderTokenAttribute($value)
    {
        return Crypt::decryptString($value);
    }



}
