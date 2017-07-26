@extends('layouts.app')

@section('header-class')
    style2
@endsection

@section('content')
    <div class="container cart-container">
        <div class="empty-cart">
            <p class="title">Order placed successfully</p>
            <p class="caption">
                Thanks, remember check your email to get update of your order.
                <br>
                <a href="/shop">Continue shopping</a></p>
        </div>
    </div>
@endsection
