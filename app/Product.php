<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $guarded = [];
    protected $table = 'products';

    public function vendor()
    {
        return $this->belongsTo(ProductVendor::class);
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function imageList()
    {
        $images = json_decode($this->images);
        $imageOrder = implode(',', $images);
        return Image::whereIn('id', $images)
                    ->orderByRaw(DB::raw("FIELD(id, $imageOrder)"))
                    ->get();
    }

    public function imageListInID()
    {
        $imageList = '';
        foreach($this->imageList() as $image){
            if($imageList == '')
                $imageList .= $image->id;
            else
                $imageList .= ",".$image->id;
        }
        return $imageList;
    }

    public function mainImage()
    {
        $images = json_decode($this->images);
        $imageOrder = implode(',', $images);
        return Image::whereIn('id', $images)
                    ->orderByRaw(DB::raw("FIELD(id, $imageOrder)"))
                    ->first();
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function tagString()
    {
        $tagString = '';
        foreach($this->tags as $tag)
            $tagString .= $tag->name.",";
        return $tagString;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
