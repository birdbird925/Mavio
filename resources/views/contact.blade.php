@extends('layouts.app')

@section('header-class')
    style2
@endsection

@section('content')
    <div class="container contact-wrapper">
        <div class="page-title">
            Contact Us
        </div>
        <div class="contact-form">
            <form action="/contact" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" cols="30" rows="5"></textarea>
                </div>
                @if(count($errors) > 0)
                    <ul class="error">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                @if(Session::has('status'))
                    <div class="status">
                        {{Session::get('status')}}
                    </div>
                @endif
                <input type="submit" value="send">
            </form>
        </div>
    </div>
@endsection
