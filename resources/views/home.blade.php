@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12" id="banner-home-user">
                <form class="form-inline" action="{{route('search')}}" method="post">
                    <div class="form-group @if($errors->any()) {{$errors->has('query') ? 'has-error' : 'has-success'}} @endif" style="width: 100%;">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <label for="query" class="sr-only">Query:</label>

                        <div class="input-group banner-form" style="margin: 0 auto;">
                            <input id="homequery"
                                   name="query"
                                   type="text"
                                   placeholder="Enter your location to find a shop..."
                                   class="form-control input-lg"
                                   value="{{old('query')}}">
                            <input type="hidden" name="location" id="my-current-location">

                            <input class="btn btn-primary btn-lg" type="submit" value="Search">
                        </div>
                    </div>
                </form>
                <h2>Welcome {{ $name or current_user()->name }}</h2>
                @if (current_user()->coffee_shop != null)
                    <h4>We're reviewing your shop at the minute, fill out some details below to help us!</h4>
                @else
                    <h4>What are you ordering today?</h4>
                @endif
            </div>
        </div>
    </div>



    <div id="home-user">
        @if (current_user()->coffee_shop == null)
            <div class="container" id="home-user-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active" style="z-index: 3">
                        <a href="#dashboard"
                           aria-controls="dashboard"
                           role="tab"
                           data-toggle="tab">Dashboard</a>
                    </li>
                    <li role="presentation" style="z-index: 2">
                        <a href="#orders"
                           aria-controls="orders"
                           role="tab"
                           data-toggle="tab">Your orders</a>
                    </li>
                    <li role="presentation" style="z-index: 1">
                        <a href="#details"
                           aria-controls="details"
                           role="tab"
                           data-toggle="tab">Your details</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="dashboard">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2>You currently have {{ current_user()->points }} KB Points</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h3>Your recent orders</h3>

                                <div class="row">
                                    @foreach($orders as $order)
                                        <div class="col-xs-12 col-sm-6 col-md-4 ">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                    {{ $order->created_at->format('jS \of F \a\t H:i') }}
                                                </div>
                                                <div class="panel-body">
                                                    <p>
                                                        <i class="fa fa-coffee"></i>

                                                        @foreach($order->order_lines as $i => $line)
                                                            {{ $order->coffee_shop->getNameFor($line->product) . ($i + 1 !== count($order->order_lines) ? ', ' : '')  }}
                                                        @endforeach
                                                    </p>

                                                    <p>
                                                        <span class="glyphicon glyphicon-map-marker"></span>
                                                        {{ $order->coffee_shop->location }}
                                                    </p>
                                                </div>
                                                <div class="panel-footer">
                                                    Total: <span class="pull-right">£ {{ number_format($order->price / 100., 2) }}</span>
                                                </div>
                                                <div class="panel-footer">
                                                    <a href="{{ route('coffee-shop.show', $order->coffee_shop->id) }}"
                                                       class="btn btn-warning">Leave Review</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <h3>Recommended coffee shops for you</h3>

                                <div class="row">
                                    @foreach(current_user()->coffee_shops->unique()->take(6) as current_user()->coffee_shop)
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="featured-coffee-shop" style="background-image: url({{current_user()->coffee_shop->mainImage() }})">
                                                <div class="info small-featured">
                                                    <h5>
                                                        {{ current_user()->coffee_shop->name }}
                                                        <div class="pull-right">
                                                            @include('coffee_shop._rating', ['rating' => current_user()->coffee_shop->getRating()])
                                                        </div>
                                                    </h5>
                                                    <p>
                                                        <i>{{ current_user()->coffee_shop->location }}</i>
                                                    </p>
                                                    <div class="actions text-center">
                                                        <a href="{{ route('coffee-shop.show', ['coffeeShop' => current_user()->coffee_shop]) }}"
                                                           class="btn btn-success">Order <span class="hidden-xs"> a Coffee </span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="orders">
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="table table-hovered">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->created_at }}</td>
                                            <td>£ {{ number_format($order->price / 100., 2) }}</td>
                                            <td>
                                                <a href="{{ route('order.success', ['order' => $order]) }}"
                                                   class="btn btn-primary btn-xs">
                                                    Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="details">
                        <form method="POST" action="{{ route('home.store') }}">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h4>Your Details</h4>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="username" name="name" value="{{ $name or current_user()->name }}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{ $email or current_user()->email }}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="drink">Pick your favourite drink</label>
                                        <select name="drink" class="form-control">

                                            @foreach ( $drinks as $drink )

                                                <option @if ($favourite === $drink) selected @endif value="{{ $drink }}">{{ $drink }}</option>

                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="twitter">Your twitter name</label>
                                        <input type="text" class="form-control" id="twitter" name="twitter" value="{{ $twitter or current_user()->twitter }}"/>
                                    </div>
                                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                                    <button class="btn btn-primary" type="submit">Update your profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="text-center">Adjust your profile!</h2>
                            <form class="form-horizontal" action="{{ route('my.profile.update') }}" method="post">
                                <div class="form-group @if($errors->any()) {{$errors->has('name') ? 'has-error' : 'has-success'}} @endif">
                                    <label for="name" class="col-sm-2">Coffee shop name:</label>

                                    <div class="col-sm-9">
                                        <input id="name"
                                               name="name"
                                               type="text"
                                               placeholder="The name of your coffee shop..."
                                               class="form-control"
                                               value="{{old('name', current_user()->coffee_shop->name)}}">
                                    </div>
                                </div>
                               <div class="form-group @if($errors->any()) {{$errors->has('location') ? 'has-error' : 'has-success'}} @endif">
                                    <label for="field-maps-location" class="col-sm-2">Address:</label>

                                    <div class="col-sm-9">
                                        <input id="field-maps-location"
                                               name="location"
                                               type="text"
                                               placeholder="The address of your coffee shop..."
                                               class="form-control"
                                               value="{{old('location', current_user()->coffee_shop->location)}}">
                                    </div>
                                </div>

                                <div class="form-group @if($errors->any()) {{$errors->has('postal_code') ? 'has-error' : 'has-success'}} @endif">
                                    <label for="postal_code" class="col-sm-2">Postal code:</label>

                                    <div class="col-sm-9">
                                        <input id="postal_code"
                                               name="postal_code"
                                               type="text"
                                               placeholder="Postal code..."
                                               class="form-control"
                                               value="{{old('postal_code', current_user()->coffee_shop->postal_code)}}">
                                    </div>
                                </div>

                                
                                <div class="form-group @if($errors->any()) {{$errors->has('county') ? 'has-error' : 'has-success'}} @endif">
                                    <label for="county" class="col-sm-2">County:</label>

                                    <div class="col-sm-9">
                                        <input id="county"
                                               name="county"
                                               type="text"
                                               placeholder="County..."
                                               class="form-control"
                                               value="{{old('county', current_user()->coffee_shop->county)}}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-xs-12">
                                    <div class="text-center">
                                      <h4>Not the correct location? Drag the pin to your coffee shop.</h4>
                                    </div>
                                    <div id="maps-container" class="draggable-marker" data-position="{{ current_user()->coffee_shop->latitude }}, {{ current_user()->coffee_shop->longitude }}"></div>
                                    <p class="help-block">You can drag the pin to be more accurate.</p>
                                </div>

                                <div class="form-group @if($errors->any()) {{$errors->has('phone_number') ? 'has-error' : 'has-success'}} @endif">
                                    <label for="phone_number" class="col-sm-2">Phone number:</label>

                                    <div class="col-sm-9">
                                        <input id="phone_number"
                                               name="phone_number"
                                               type="text"
                                               placeholder="Phone number..."
                                               class="form-control"
                                               value="{{old('phone_number', current_user()->coffee_shop->phone_number)}}">
                                    </div>
                                </div>
                                <div class="form-group @if($errors->any()) {{$errors->has('about') ? 'has-error' : 'has-success'}} @endif">
                                    <label for="about" class="col-sm-2">Tell customers about your coffee shop: </label>

                                    <div class="col-sm-9">
                                        <textarea id="about"
                                               rows="5"
                                               name="about"
                                               placeholder=""
                                               class="form-control">{{old('about', current_user()->coffee_shop->about)}}</textarea>
                                    </div>
                                </div>

                                <input type="hidden"
                                       name="latitude"
                                       value="{{old('latitude', current_user()->coffee_shop->latitude)}}"
                                       id="latitude-field">
                                <input type="hidden"
                                       name="longitude"
                                       value="{{old('longitude', current_user()->coffee_shop->longitude)}}"
                                       id="longitude-field">
                                <input type="hidden"
                                       name="place_id"
                                       value="{{old('place_id', current_user()->coffee_shop->place_id)}}"
                                       id="place-id-field">
                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">

                                <div class="form-group">
                                    <div class="col-sm-9">
                                        <input type="submit" class="btn btn-lg btn-primary" value="Update your coffee shop">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection