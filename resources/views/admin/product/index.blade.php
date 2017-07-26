@extends('layouts.admin')

@section('page-direction')
    Products
@endsection

@section('product-sidebar')
    active
@endsection

@section('content')
    <div class="col-sm-12">
        @if($products->count() == 0)
            <div class="card">
                <div class="content">
                    There are not any product yet.
                    <br>
                    <a href="/admin/product/create">Create Product</a>
                </div>
            </div>
        @else
            <a href="/admin/product/create" class="btn btn-primary">Add Product</a>
            <table id="data-table" class="mdl-data-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Vendor</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Visibility</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr href="/admin/product/{{$product->id}}/edit">
                            <td><img src="{{$product->mainImage()->getSrc()}}" width="100"></td>
                            <td>{{$product->title}}</td>
                            <td>{{$product->type ? $product->type->name : '-'}}</td>
                            <td>{{$product->vendor ? $product->vendor->name : '-'}}</td>
                            <td>{!!$product->compare_price ? '<del>'.$product->compare_price.'</del>' : '' !!} {{$product->price}}</td>
                            <td>{{$product->quantity}}</td>
                            <td><span class="hide">{{$product->visible ? 1 : 0}}</span><i class="fa fa-{{$product->visible ? 'check' : 'times' }}-circle"></i></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
