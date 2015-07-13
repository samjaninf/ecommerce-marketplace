@extends('app')

@section('page-title')
    {{$coffeeShop->name}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    {{$coffeeShop->name}}
                    <span>
                        <a href="{{ route('admin.coffee-shop.show', ['coffeeShop' => $coffeeShop])}}">
                            Show details
                        </a>
                    </span>
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
                <form action="{{ route('admin.coffee-shop.update', ['coffeeShop' => $coffeeShop]) }}"
                      class="form-horizontal"
                      method="post">
                    <div class="form-group @if($errors->any()) {{$errors->has('name') ? 'has-error' : 'has-success'}} @endif">
                        <label for="name" class="col-sm-2 control-label">Name:</label>

                        <div class="col-sm-10 col-md-6">
                            <input id="name"
                                   name="name"
                                   type="text"
                                   placeholder="Name..."
                                   class="form-control"
                                   value="{{old('name', $coffeeShop->name)}}">
                        </div>
                    </div>

                    <div class="form-group @if($errors->any()) {{$errors->has('location') ? 'has-error' : 'has-success'}} @endif">
                        <label for="location" class="col-sm-2 control-label">Location:</label>

                        <div class="col-sm-10 col-md-6">
                            <input id="location"
                                   name="location"
                                   type="text"
                                   placeholder="Location..."
                                   class="form-control"
                                   value="{{old('location', $coffeeShop->location)}}">
                        </div>
                    </div>

                    <div class="form-group @if($errors->any()) {{$errors->has('postal_code') ? 'has-error' : 'has-success'}} @endif">
                        <label for="postal_code" class="col-sm-2 control-label">Postal code:</label>

                        <div class="col-sm-10 col-md-6">
                            <input id="postal_code"
                                   name="postal_code"
                                   type="text"
                                   placeholder="Postal code..."
                                   class="form-control"
                                   value="{{old('postal_code', $coffeeShop->postal_code)}}">
                        </div>
                    </div>

                    <div class="form-group @if($errors->any()) {{$errors->has('phone_number') ? 'has-error' : 'has-success'}} @endif">
                        <label for="phone_number" class="col-sm-2 control-label">Phone number:</label>

                        <div class="col-sm-10 col-md-6">
                            <input id="phone_number"
                                   name="phone_number"
                                   type="text"
                                   placeholder="Phone number..."
                                   class="form-control"
                                   value="{{old('phone_number', $coffeeShop->phone_number)}}">
                        </div>
                    </div>
                    
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-9">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
