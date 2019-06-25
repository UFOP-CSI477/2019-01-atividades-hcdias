<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $fillable = [
        'name','price','user_id'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function tests()
    {
        return $this->hasMany('App\Test');
    }
}
