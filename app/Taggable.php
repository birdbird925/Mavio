<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    protected $guarded = [];
    public $timestamps  = false;
    protected $table = 'taggables';

}
