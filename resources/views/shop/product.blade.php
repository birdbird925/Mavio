@extends('layouts.app')

@section('header-class')
    style2
@endsection

@section('content')
    <div class="container product-container">
        <div class="row">
            <div class="col-sm-6">
                <img src="{{$product->mainImage()->getSrc()}}" class="main-image">
                @if($product->imageList()->count() > 1)
                    @foreach($product->imageList() as $image)
                        <img src="{{$image->getSrc()}}" class="thumb">
                    @endforeach
                @endif
            </div>
            <div class="col-sm-6 product-info">
                <HR></HR>
                @if($product->vendor)
                    <div class="vendor">{{$product->vendor->name}}</div>
                @endif
                <div class="title">{{$product->title}}</div>
                <div class="price">RM {{$product->price}} {!!$product->compare_price ? '<del>RM '.$product->compare_price.'</del>' : ''!!}</div>
                <div class="option-wrapper">
                    <select name="quantity" data-quantity="{{$product->quantity}}">
                        <option value="0">Quantity</option>
                        @for($num = 1; $num < 10; $num++)
                            <option value="{{$num}}">{{$num}}</option>
                        @endfor
                    </select>
                </div>
                @if($product->quantity == 0)
                    <div class="out-of-stock">Out of Stocks</div>
                @else
                    <button class="add-cart" data-id={{$product->id}}>Add to cart</button>
                @endif
                <div class="status"></div>
                <hr>
                <div class="heading">Description</div>
                <div class="description">
                    {{-- {!!$product->description!!} --}}
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error illo consequuntur, possimus odio veritatis molestias ipsum cum. Explicabo iste ipsa labore alias dolores, quaerat, eaque amet, optio voluptatibus ut eum.
                    <br><br>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur expedita excepturi nisi quis voluptas enim laudantium error cupiditate, magni nam fugit sunt nemo amet, suscipit quo aperiam atque. Sint, amet.
                </div>
                <ul class="social-share">
                    <li class="facebook"><a href="#"></a></li>
                    <li class="twitter"><a href="#"></a></li>
                    <li class="google"><a href="#"></a></li>
                </ul>
                <hr>
            </div>
        </div>
    </div>
@endsection
