<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'name', 'username',
    ];


    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function watches()
    {
        return $this->hasMany(Watch::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function registration()
    {
        return $this->hasOne(Registration::class);
    }

}
