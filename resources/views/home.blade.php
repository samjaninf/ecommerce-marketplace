@extends('app')

@section('content')

    <div style="padding: 0px;" class="container-fluid">
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
                    <h4>Sorry your account is not live!</h4>
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
                                        <label for="displayname">Display Name</label>
                                        <input type="text" class="form-control" id="displayname" name="displayname" value="{{ $displayname or current_user()->display_name }}"/>
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
                            <h2 class="text-center">Your account is not live!</h2>
                            <p class="text-center">Sorry but your account isn't live. To find out why please email us at <a href="mailto:support@koolbeans.co.uk">support@koolbeans.co.uk</a> or call us.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection