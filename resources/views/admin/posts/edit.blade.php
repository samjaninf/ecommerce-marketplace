@extends('app')

@section('page-title')
    Editing {{ $post->title }}
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
        <form action="{{ route('admin.post.update', [$post->id]) }}" class="form-horizontal" method="post">
            @include('admin.posts._form')
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="put">

            <div class="form-group">
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-success" value="Add a post">
                </div>
            </div>
        </form>
    </div>
@stop
