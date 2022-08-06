<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_point extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
