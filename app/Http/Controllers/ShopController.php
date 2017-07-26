<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductType;
use App\ProductVendor;

class ShopController extends Controller
{
    public function index()
    {
        $categories = ProductType::all();
        $brands = ProductVendor::all();
        $products = Product::where('visible', 1)->where('deleted', 0)->get();
        switch(request()->input('sort')){
            case 'recent':
                $products = Product::where('visible', 1)->where('deleted', 0)->latest()->get();
                break;

            case 'cheapest':
                $products = Product::where('visible', 1)->where('deleted', 0)->orderBy('price')->get();
                break;

            case 'expensive':
                $products = Product::where('visible', 1)->where('deleted', 0)->orderBy('price', 'DESC')->get();
                break;
        }
        return view('shop.index', compact('products', 'categories', 'brands'));
    }

    public function product($id)
    {
        $product = Product::where('visible', 1)->where('deleted', 0)->where('id', $id)->first();
        if(!$product) abort('404');
        return view('shop.product', compact('product'));
    }
}
