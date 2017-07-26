<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    public $timestamps  = false;
    protected $table = 'tags';

    public function products()
    {
        return $this->morphedByMany('App\Product', 'taggable');
    }

}
