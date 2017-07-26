<!Doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Basic E-Commerce</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  	<meta name="viewport" content="width=device-width" />

  	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/admin/icon.css">
	<link rel="stylesheet" href="/css/admin/style.css">
	<link rel="stylesheet" href="/css/admin/animate.min.css">
	<link rel="stylesheet" href="/css/admin/material.css">
	<link rel="stylesheet" href="/css/admin/datatable-material.css">
	<link rel="stylesheet" href="/css/admin/tagsinput.css">
	<link rel="stylesheet" href="/css/admin/dropzone.css">
	<link href="/css/admin.css" rel="stylesheet">
</head>
<body>
<div class="wrapper" id="admin-wrapper">
  	<div class="sidebar" data-color="" data-image="/images/demo/sidebar-5.jpg">
  		<div class="sidebar-wrapper">
      		<div class="logo">
        		<a href="/admin" class="simple-text">
					DEMO
        		</a>
      		</div>

            <ul class="nav">
                <li class="@yield('dashboard-sidebar')">
                    <a href="/admin">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
				<li class="@yield('product-sidebar')">
					<a href="/admin/product">
						<i class="pe-7s-wristwatch"></i>
						<p>Product</p>
					</a>
				</li>
				<li class="@yield('order-sidebar')">
					<a href="/admin/order">
						<i class="pe-7s-note2"></i>
						<p>
							@if($newOrder)
								<div class="new-notification">
									{{$newOrder}}
								</div>
							@endif
							Order
						</p>
					</a>
				</li>
				<li class="@yield('customer-sidebar')">
					<a href="/admin/customer">
						<i class="pe-7s-users"></i>
						<p>Customer</p>
					</a>
				</li>
				<li class="@yield('message-sidebar')">
					<a href="/admin/message">
						<i class="pe-7s-mail"></i>
						<p>
							@if($newMessage)
								<div class="new-notification">
									{{$newMessage}}
								</div>
							@endif
							Message
						</p>
					</a>
				</li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

					<ul class="page-direction">
						@yield('page-direction')
					<ul>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
						<li>
                           <a href="/">
                               View Store
                            </a>
                        </li>
                        <li>
                           <a href="/admin/account">
                               Account
                            </a>
                        </li>
						<li>
							<a href="/logout">Logout</a>
						</li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
				    @yield('content')
                </div>
            </div>
        </div>

    </div>
</div>


</body>
	<script src="/js/admin.js"></script>
	<script src="/js/admin/ckeditor/ckeditor.js"></script>
	<script src="/js/admin/dropzone.js"></script>
	<script src="/js/admin/dropzone-config.js"></script>
	@include('layouts.partials.alert')
</html>
