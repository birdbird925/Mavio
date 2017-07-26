@extends('layouts.admin')

@section('page-direction')
    Dashboard
@endsection

@section('dashboard-sidebar')
    active
@endsection

@section('content')
    <div class="col-sm-3">
        <div class="card data-card">
            <div class="content">
                <i class="pe-7s-note2"></i>
                <div class="data">
                    {{$orders->count()}}
                </div>
                <p class="description">
                    Total Orders
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card data-card">
            <div class="content">
                <i class="pe-7s-wristwatch"></i>
                <div class="data">
                    {{$products->count()}}
                </div>
                <p class="description">
                    Total Products
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card data-card">
            <div class="content">
                <i class="pe-7s-users"></i>
                <div class="data">
                    {{$customers->count()}}
                </div>
                <p class="description">
                    Total Customers
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card data-card">
            <div class="content">
                <i class="pe-7s-cash"></i>
                <div class="data">
                    ${{$amount}}
                </div>
                <p class="description">
                    Total Sales
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Last 7 days Sales
                </h4>
            </div>
            <div class="content">
                <canvas id="myChart" width="100%" height="60px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="header">
                <h4 class="title">Product Statistic</h4>
            </div>
            <div class="content" id="product-statistic">
                @if($products->count() == 0)
                    There are not any product yet.
                    <br>
                    <a href="/admin/product/create">Create Product</a>
                @else
                    <div class="form-group">
                        <select name="product-statistic" class="form-control">
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <img src="{{$productStatistic['image']}}" width="100%">
                    <hr>
                    <label class="title">Sale Details</label>
                    <br>
                    <ul>
                        <li>
                            <label>Today : </label>
                            <span class="today">{{$productStatistic['today']}}</span> pcs
                        </li>
                        <li>
                            <label>Week : </label>
                            <span class="week">{{$productStatistic['week']}}</span> pcs
                        </li>
                        <li>
                            <label>Month : </label>
                            <span class="month">{{$productStatistic['month']}}</span> pcs
                        </li>
                        <li>
                            <label>Total : </label>
                            <span class="total">{{$productStatistic['total']}}</span> pcs
                        </li>
                        <li>
                            <label>Sales : </label>
                            RM <span class="sale">{{number_format($productStatistic['sale'], 2)}}</span>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
