@extends('layouts.admin')

@section('page-direction')
    <a href="/admin/customer">Customers</a> / Customer
@endsection

@section('customer-sidebar')
    active
@endsection

@section('content')
    @if($customer->order->count() == 0)
        <div class="col-sm-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Customer Info</h4>
                </div>
                <div class="content">
                    <ul>
                        <li>
                            <span>Join Since: </span>
                            {{$customer->created_at->diffForHumans()}}
                        </li>
                        <li>
                            <span>Email: </span>
                            {{$customer->email}}
                        </li>
                        <li>
                            <span>Order:</span>
                            Zero purchase
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h4 class="title">Order Summary</h4>
                </div>
                <div class="content">
                    @foreach($customer->order as $order)
                        <div class="order-row summary-row">
                            <div class="summary-header">
                                <a href="/admin/order/{{$order->id}}" class="header-title">
                                    <i class="fa fa-{{$order->order_status == 1 ? 'check-circle' : 'times-circle'}}"></i>
                                    {{$order->orderCode()}}
                                </a>

                                <div class="pull-right date">
                                    {{$order->created_at->toDateTimeString()}}
                                </div>
                            </div>
                            <div class="order-item-summary item-summary">
                                @foreach($order->items as $item)
                                    <div class="order-item">
                                        <div class="product-image">
                                            <img src="{{$item->product->mainImage()->getSrc()}}" width="120">
                                        </div>
                                        <div class="product-info">
                                            <div class="name">
                                                <a href="/admin/product/{{$item->product->id}}/edit">{{$item->product->title}}</a>
                                            </div>
                                            <p>
                                                Quatity: {{$item->quantity}} pcs
                                                <br>
                                                Price: RM {{$item->price}}
                                                <br>
                                                Total: RM {{$item->total()}}
                                            </p>
                                        </div>
                                        <div class="item-info"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title">Customer info</h4>
                </div>
                <div class="content">
                    <ul>
                        <li>
                            <span>Join Since: </span>
                            {{$customer->created_at->diffForHumans()}}
                        </li>
                        <li>
                            <span>Email: </span>
                            {{$customer->email}}
                        </li>
                        <li>
                            <span>Country: </span>
                            {{$customer->lastOrder()->country}}
                        </li>
                    </ul>
                    <hr>
                    <ul>
                        <li>
                            <span>Last order:</span>
                            {{$customer->lastOrder()->created_at->toDateTimeString()}}
                        </li>
                        <li>
                            <span>Order:</span>
                            @if($customer->successOrder()->count() != $customer->order->count())
                                <del>{{$customer->order->count() }}</del>
                                {{$customer->successOrder()->count()}} Purchase
                            @else
                                {{$customer->order->count() }} Purchase
                            @endif
                        </li>
                        <li>
                            <span>Item:</span>
                            @if($customer->successOrder()->count() != $customer->order->count())
                                <del>{{$customer->totalItem() }}</del>
                                {{$customer->successTotalItem()}} Watchs
                            @else
                                {{$customer->totalItem() }} Watchs
                            @endif
                        </li>
                        <li>
                            <span>Spent:</span>
                            @if($customer->successOrder()->count() != $customer->order->count())
                                <del>$ {{$customer->totalSpent() }}</del>
                                $ {{$customer->successTotalSpent()}}
                            @else
                                $ {{$customer->totalSpent()}}
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endsection
