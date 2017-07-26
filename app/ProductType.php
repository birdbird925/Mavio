<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = ['name'];
    public $timestamps  = false;
    protected $table = 'product_types';

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
