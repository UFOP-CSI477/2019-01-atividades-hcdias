<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'user_id','procedure_id','date'
    ];

    public function procedures()
    {
        return $this->belongsTo('App\Procedure');
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
