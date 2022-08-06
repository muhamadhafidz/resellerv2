<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    
    public function product_images()
    {
        return $this->hasMany('App\Product_image', 'product_id');
    }
    public function product_points()
    {
        return $this->hasMany('App\Product_point', 'product_id');
    }
}
