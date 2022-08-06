<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function transaction_products()
    {
        return $this->hasMany('App\Transaction_product', 'transaction_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
