<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'price', 'provider_type', 'provider_id'];

    public function provider()
    {
        return $this->belongsTo('App\Providers', 'provider_id');
    }

    public function productVariations()
    {
        return $this->hasMany('App\ProductVariations', 'product_id');
    }
}
