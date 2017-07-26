@extends('layouts.admin')

@section('page-direction')
    <a href="/admin/product">Products</a> / Edit
@endsection

@section('product-sidebar')
    active
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="content">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{$product->title}}">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="ckeditor form-control">{!!$product->description!!}</textarea>
                </div>
                <div class="form-group">
                    <label class="full">
                        Images
                        <a class="header-link" id="dz-upload-triggle">Upload Images</a>
                    </label>
                    @include('layouts.partials.dropzone', [
                        'dropzoneImage' => $product->imageList(),
                    ])
                    <input type="hidden" name="productImage" value="{{ $product->imageListInID() }}">
                    <input type="hidden" name="deleteImage" value="">
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control" value="{{$product->price}}">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="{{$product->quantity}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Compare Price</label>
                            <input type="number" name="compare_price" class="form-control" value="{{$product->compare_price}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="header">
                <h4 class="title">Organization</h4>
            </div>
            <div class="content">
                <input type="checkbox" name="visible" id="visibility" {{$product->visible ? 'checked' : ''}}> <label for="visibility">Visibility</label>
                <hr>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="type" class="form-control" list="data-type" value="{{$product->type ? $product->type->name : ''}}">
                    @if($types->count() > 0)
            		<datalist id="data-type">
            			@foreach($types as $t)
            				<option value="{{ $t->name }}"></option>
            			@endforeach
            		</datalist>
            		@endif
                </div>
                <div class="form-group">
                    <label>Vendor</label>
                    <input type="text" name="vendor" class="form-control" list="data-vendor" value="{{$product->vendor ? $product->vendor->name : ''}}">
                    @if($vendors->count() > 0)
            		<datalist id="data-vendor">
            			@foreach($vendors as $v)
            				<option value="{{ $v->name }}"></option>
            			@endforeach
            		</datalist>
            		@endif
                </div>
                <div class="form-group">
                    <label>Tags</label>
                    <input type="text" name="tag" class="form-control tagsinput" value={{$product->tags ? $product->tagString() : ''}}>
                </div>
                <hr>
                <button class="btn btn-primary btn-full" id="btnSaveProduct" data-id="{{$product->id}}">Save</button>
                <form action="/admin/product/{{$product->id}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn btn-danger btn-full required-confirm">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
