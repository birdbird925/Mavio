<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add($id)
    {
        $subTotal = 0;
        $productFound = false;
        $cartItem = request('quantity');
        $product = Product::where('visible', 1)->where('deleted', 0)->where('id', $id)->first();
        if(request('quantity') > $product->quantity)
            return 'There are only '.$product->quantity.' of '.$product->title.' in stock';

        if(session()->has('cart.item')){
            foreach(session('cart.item') as $index=>$item) {
                if($item['id'] == $product->id) {
                    $productFound = true;
                    if(request('quantity') + $item['quantity'] > $product->quantity){
                        session(['cart.item.'.$index.'.quantity' => $product->quantity]);
                        return 'All '.$product->quantity.' '.$product->title.' are in your cart';
                    }
                    else
                        session(['cart.item.'.$index.'.quantity' => request('quantity') + $item['quantity']]);
                }

                $cartItem += $item['quantity'];
                $subTotal += $item['quantity'] * $item['price'];
            }
        }
        session(['cart.subtotal'=>$subTotal]);
        if(!$productFound){
            session()->push('cart.item', [
                'id' => $product->id,
                'image' => $product->mainImage()->getSrc(),
                'name' => $product->title,
                'price' => $product->price,
                'quantity' => request('quantity'),
            ]);
            session(['cart.subtotal'=>($subTotal+$product->price * request('quantity'))]);
        }

        return $cartItem;
    }

    public function update($id, $action)
    {
        $subTotal = 0;
        $product = Product::where('visible', 1)->where('deleted', 0)->where('id', $id)->first();
        foreach(session('cart.item') as $index=>$item) {
            if($item['id'] == $id) {
                switch($action) {
                    case 'minus':
                        if($item['quantity'] == 0)
                            session()->forget('cart.item.'.$index);
                        else{
                            session(['cart.item.'.$index.'.quantity' => ($item['quantity'] - 1)]);
                            $subTotal += ($item['quantity']-1) * $item['price'];
                        }
                        break;
                    case 'plus':
                        if($product->quantity == $item['quantity'])
                            return 'Item out of stock ';
                        else {
                            session(['cart.item.'.$index.'.quantity' => ($item['quantity'] + 1)]);
                            $subTotal += ($item['quantity']+1) * $item['price'];
                        }
                        break;
                    case 'remove':
                        session()->forget('cart.item.'.$index);
                        break;
                }
            }
            else {
                $subTotal += $item['quantity'] * $item['price'];
            }
        }

        session(['cart.subtotal'=>$subTotal]);
    }
}
