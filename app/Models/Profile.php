<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;


    protected $primaryKey = 'user_id';

    public $incrementing = false;

    // one profile follow one user

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
