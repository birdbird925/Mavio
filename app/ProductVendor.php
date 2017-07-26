<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVendor extends Model
{
    protected $fillable = ['name'];
    public $timestamps  = false;
    protected $table = 'product_vendors';

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
