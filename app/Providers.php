<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Providers extends Model
{
    protected $table = 'providers';
    protected $fillable = ['name', 'provider_type'];

    public function products()
    {
        return $this->hasMany('App\Products', 'provider_id');
    }

    public function productVariations()
    {
        return $this->hasMany('App\ProductVariations', 
    'provider_id');
    }
}
