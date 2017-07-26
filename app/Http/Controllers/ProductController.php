<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\OrderItem;
use App\ProductType;
use App\ProductVendor;
use App\Product;
use App\Tag;
use App\Image;
use App\Taggable;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::latest()->where('deleted', 0)->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $types = ProductType::all();
        $vendors = ProductVendor::all();
        $tags = Tag::all();
        return view('admin.product.create', compact('types', 'vendors', 'tags'));
    }

    public function store()
    {
        $productData = request()->except(['vendor', 'type', 'tag']);
        if(request('vendor') != "") {
            $vendor = ProductVendor::firstOrCreate(['name' => request('vendor')]);
            $productData['vendor_id'] = $vendor->id;
        }
        if(request('type') != "") {
            $type = ProductType::firstOrCreate(['name' => request('type')]);
            $productData['type_id'] = $type->id;
        }
        $productData['images'] = json_encode(explode(",", request('images')));
        $product = Product::create($productData);

        if(request('tag') != '') {
            foreach (explode(",", request('tag')) as $name){
                $tag = Tag::firstOrCreate(['name' => $name]);
                Taggable::create(['tag_id' => $tag->id, 'taggable_id' => $product->id, 'taggable_type' => 'App\Product']);
            }
        }
        return Response::json(['error' => false,'code' => 200], 200);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        if($product->deleted) abort('404');
        $types = ProductType::all();
        $vendors = ProductVendor::all();
        $tags = Tag::all();
        return view('admin.product.edit', compact('types', 'vendors', 'tags', 'product'));
    }

    public function update($id)
    {
        $product = Product::find($id);
        $productData = request()->except(['vendor', 'type', 'tag', 'deleteImages']);
        if(request('vendor') != "") {
            $vendor = ProductVendor::firstOrCreate(['name' => request('vendor')]);
            $productData['vendor_id'] = $vendor->id;
        }
        if(request('type') != "") {
            $type = ProductType::firstOrCreate(['name' => request('type')]);
            $productData['type_id'] = $type->id;
        }
        $productData['images'] = json_encode(explode(",", request('images')));
        $product->update($productData);

        if(request('tag') != '') {
            Taggable::where('taggable_id', $product->id)->where('taggable_type', 'App\Product')->delete();
            foreach (explode(",", request('tag')) as $name){
                $tag = Tag::firstOrCreate(['name' => $name]);
                Taggable::create(['tag_id' => $tag->id, 'taggable_id' => $product->id, 'taggable_type' => 'App\Product']);
            }
        }

        return Response::json(['error' => false,'code' => 200], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // hide product
        if(OrderItem::where('product_id', $id)->count() > 0) {
            $product->deleted = 1;
            $product->save();
        } // delete product
        else {
            // delete product image
            foreach($product->imageList() as $image) {
                $name = $image->name;
                $path = $image->path;
                if(File::exists($path.$name))
                    File::delete($path.$name);
                $image->delete();
            }
            Taggable::where('taggable_id', $product->id)->where('taggable_type', 'App\Type')->delete();
            $product->delete();
        }

        return redirect("/admin/product");
    }
}
