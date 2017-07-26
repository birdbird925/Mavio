@extends('layouts.app')

@section('header-class')
    style2
@endsection

@section('content')
    <div class="container shop-container">
        @include('shop.filter')
        <div class="row product-wrapper">
            @foreach($products as $product)
                <a href="/product/{{$product->id}}">
                    @if($loop->iteration == 1 || $loop->iteration == 6 || $loop->iteration % 10 == 1 || $loop->iteration % 10 == 6)
                    <div class="col-sm-8 col-xs-6 product-grid brand{{$product->vendor_id}} category{{$product->type_id}} {{$product->price < 50 ? 'price-below' : ($product->price > 150 ? 'price-more' : 'price-between')}}">
                    @else
                    <div class="col-sm-4 col-xs-6 product-grid brand{{$product->vendor_id}} category{{$product->type_id}} {{$product->price < 50 ? 'price-below' : ($product->price > 150 ? 'price-more' : 'price-between')}}">
                    @endif
                        <div class="product-image" style="background-image: url({{$product->mainImage()->getSrc()}})"></div>
                        <div class="product-name">{{$product->title}}</div>
                        <div class="product-price">RM {{$product->price}} {!!$product->compare_price ? '<del>RM '.$product->compare_price.'</del>' : ''!!}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
