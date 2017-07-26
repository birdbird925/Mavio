@extends('layouts.app')

@section('header-class')
    style2
@endsection

@section('content')
    <div class="container cart-container">
        @if(sizeof(Session::get('cart.item')) == 0)
            <div class="empty-cart">
                <p class="title">Your cart was empty</p>
                <p class="caption">Sounds like a good time to <a href="/shop">start shopping</a></p>
            </div>
        @else
            <div class="page-title">Cart</div>
            <table>
                @foreach(Session::get('cart.item') as $index=>$item)
                    <tr>
                        <td class="product-info">
                            <a href="/product/{{$item['id']}}">
                                <img src="{{$item['image']}}">
                                <div class="product-name">{{$item['name']}}</div>
                            </a>
                        </td>
                        <td class="cart-info">
                            <div class="price">
                                RM {{number_format($item['price'], 2)}}
                            </div>
                            <div class="quantity-control">
                                <span class="minus control" data-id="{{$item['id']}}">-</span>
                                <span class="quantity">{{$item['quantity']}}</span> pcs
                                <span class="plus control" data-id="{{$item['id']}}">+</span>
                                <span class="error"></span>
                            </div>
                            <div class="remove-control" data-id="{{$item['id']}}">Remove</div>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="cart-footer">
                <div class="footer-row">
                    <div class="left">Subtotal</div>
                    <div class="right">RM {{number_format(Session::get('cart.subtotal'),2)}}</div>
                </div>
                <div class="footer-row">
                    <div class="left">Shipping</div>
                    <div class="right">RM 10.00</div>
                </div>
                <div class="footer-row">
                    <div class="left">Total</div>
                    <div class="right">RM {{number_format(Session::get('cart.subtotal') + 10, 2)}}</div>
                </div>
                <a href="/shop">Continue shopping</a>
                <form action="/checkout" method="post">
                    {{ csrf_field() }}
                    <button id="btnCheckout">Checkout</button>
                </form>
            </div>
        @endif
    </div>
@endsection
