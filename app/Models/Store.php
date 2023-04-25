<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Store extends Authenticatable /*implements MustVerifyEmail*/
{
    use HasFactory,HasApiTokens,Notifiable;

    protected $fillable = [
        'name', 'slug','email','password','type','email_verified_at'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $connection = 'mysql';

    protected $table = 'stores';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    // one store has many products
    public function products()
    {
        return $this->hasMany(Product::class,'store_id','id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasAbility($ability)
    {
        foreach ($this->roles as $role) {
            if (in_array($ability, $role->abilities)) {
                return true;
            }
        }

        return false;
    }




}
