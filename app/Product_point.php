<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_point extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
