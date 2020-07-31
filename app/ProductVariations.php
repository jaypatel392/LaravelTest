<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
    protected $table = 'product_variations';
    protected $fillable = ['name', 'price', 'provider_type', 'provider_id', 'product_id'];

    public function providers()
    {
        return $this->belongsTo('App\Providers');
    }
    
    public function product()
    {
        return $this->belongsTo('App\Products');
    }
}
