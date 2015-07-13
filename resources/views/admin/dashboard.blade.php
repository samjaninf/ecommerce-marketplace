@extends('app')

@section('page-title')
    Admin dashboard
@endsection

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

        @if(!$applications->isEmpty())
            <div class="row">
                <div class="col-xs-12">
                    <p class="alert alert-info">
                        <a href="#" id="showApplications">
                            You have some new applications! Click here to go through them.
                        </a>
                    </p>

                    <table id="applications" class="table table-hover hide no-heading">
                        <caption>Applications</caption>
                        <tbody>
                        @foreach($applications as $coffeeShop)
                            <tr>
                                <td>{{$coffeeShop->name}}</td>
                                <td>{{$coffeeShop->location}}</td>
                                <td>
                                    <a href="{{route('admin.coffee-shop.show', ['coffee_shop' => $coffeeShop])}}"
                                       class="btn btn-primary btn-xs pull-right">
                                        More info
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-xs-12">
                <h2>
                    Most profitable coffee shops
                    <span>
                        <a href="{{ route('admin.coffee-shop.index') }}">List all coffee shops</a> |
                        <a href="{{ route('admin.reporting') }}">Product sales</a>
                    </span>
                </h2>
                @if(!$profitable->isEmpty())
                    <ul class="list-group">
                        @foreach($profitable as $coffeeShop)
                            <li class="list-group-item">
                                <span class="badge">£ {{($coffeeShop->aggregate / 100.) ?: 0}}</span>
                                <a href="{{ route('admin.coffee-shop.show', ['coffeeShop' => $coffeeShop->id]) }}">
                                    {{$coffeeShop->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="alert alert-warning">No coffee shop is registered yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
