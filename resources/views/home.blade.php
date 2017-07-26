@extends('layouts.app')

@section('content')
<div class="container-fluid hero-slider-wrapper">
    <ul class="hero-slider" id="lightSlider">
        <li style="background-image: url(/demo/hero-image.png)"></li>
    </ul>
</div>

<div class="container">
    {{-- <div class="section category-section">
        <div class="title">
            Categories
        </div>
        <a href="/shop">
            <div class="category-grid">
                <div class="text">Men</div>
            </div>
        </a>
        <a href="/shop">
            <div class="category-grid">
                <div class="text">Women</div>
            </div>
        </a>
        <a href="/shop">
            <div class="category-grid">
                <div class="text">Hats</div>
            </div>
        </a>
        <a href="/shop">
            <div class="category-grid">
                <div class="text">Shoes</div>
            </div>
        </a>
        <div style="clear: both"></div>
    </div> --}}
    <div class="section product-section">
        <div class="title">
            Featured
        </div>
        @foreach($featured as $product)
            <a href="/product/{{$product->id}}">
                <div class="col-md-3 col-xs-6 product-grid">
                    <div class="product-image" style="background-image: url({{$product->mainImage()->getSrc()}})"></div>
                    <div class="product-name">{{$product->title}}</div>
                    <div class="product-price">RM {{$product->price}} {!!$product->compare_price ? '<del>RM '.$product->compare_price.'</del>' : ''!!}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
