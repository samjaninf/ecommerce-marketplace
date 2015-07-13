@extends('app')

@section('page-title')
    Recent sales
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    @yield('page-title')
                    <span id="page-actions" class="admin">
                        <a href="{{ route('admin.home') }}" class="btn btn-primary">Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Product management</a>
                        <a href="{{ route('admin.coffee-shop.index') }}" class="btn btn-primary">Coffee Shops</a>
                        <a href="{{ route('admin.sales') }}" class="btn btn-primary">Sales</a>
                        <a href="{{ route('admin.reporting') }}" class="btn btn-primary">Reporting</a>
                        <a href="{{ route('admin.export') }}" class="btn btn-primary">Export</a>
                        <a href="{{ route('admin.users') }}" class="btn btn-primary">Customers</a>
                        <a href="{{ route('admin.post.index') }}" class="btn btn-primary">All posts</a>
                    </span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                @if($orders)
                    <ul class="list-group">
                        @foreach($orders as $order)
                            <li class="list-group-item">
                                <span class="info-price-dashboard">
                                    £ {{$order->price / 100.}}
                                </span> in {{$order->coffee_shop->name}}, {{$order->coffee_shop->location}}
                                <span class="pull-right">
                                    {{$order->created_at->format('Y-m-d H:i')}}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="alert alert-danger">No sales made in the last 48 hours</p>
                @endif
            </div>
        </div>
    </div>
@stop
