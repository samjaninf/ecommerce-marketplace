@extends('app')

@section('page-title')
    {{$coffeeShop->name}}
@endsection

@section('content')
    <div id="coffee-shop-presentation">
        <div class="container-fluid" id="show-coffee-shop">
            <div class="row">
                <div class="col-xs-12" id="coffee-shop-image" style="background-image: url({{$coffeeShop->mainImage()}})">
                </div>
            </div>
        </div>

        <div id="best-review-and-features-available">
            <div class="container" id="coffee-shop-info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-9">
                        <h1>@yield('page-title')</h1>
                        <h3>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            {{$coffeeShop->location}}
                            <hr class="hide visible-xs-block visible-sm-block">
                            <br class="hide visible-md">
                            <span class="ratings">
                                @include('coffee_shop._rating')
                            </span>
                            <a href="order" class="btn btn-success hide visible-xs-inline visible-sm-inline pull-right">
                                Order a coffee
                            </a>
                        </h3>
                    </div>
                    <div class="col-md-3 hidden-xs hidden-sm">
                        <div class="panel panel-primary">
                            <div class="panel-heading ">Order your coffee</div>
                            <div class="panel-body">
                                <form action="order">
                                    <label>
                                        <span class="glyphicon glyphicon-map-marker"></span>
                                        <span class="panel-input">
                                            {{$coffeeShop->name}}
                                        </span>
                                    </label>

                                    <label>
                                        <i class="fa fa-coffee"></i>
                                        <select name="" class="panel-input">
                                            <option value="">Select your drink</option>
                                        </select>
                                    </label>

                                    <label>
                                        <span class="glyphicon glyphicon-time"></span>
                                        <select name="" class="panel-input">
                                            <option value="">Pickup time</option>
                                        </select>
                                    </label>

                                    <input type="submit" class="btn btn-success" value="Place order">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" id="coffee-shop-description">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-9">
                        <div class="row">
                            <div class="col-xs-6" id="coffee-shop-best-review">
                                @if($bestReview !== null)
                                    {{$bestReview->review}}
                                @else
                                    No review has been written yet!
                                    <a href="review">Click here</a> to write one!
                                @endif
                            </div>

                            <div class="col-xs-6">
                                Images
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="coffee-shop-about">
            @if(current_user()->coffee_shop->id === $coffeeShop->id || current_user()->role === 'admin')
                <div class="row">
                    <div class="col-xs-12">
                        @if(current_user()->role === 'admin')
                            <a href="{{ route('admin.coffee-shops.show') }}" class="btn btn-primary">
                                Review performances
                            </a>
                        @else
                            <a href="{{ route('my-shop') }}" class="btn btn-primary">
                                Manage your shop
                            </a>
                        @endif
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9">
                    <div class="row">
                        <div class="col-xs-6">
                            <h4>About the shop</h4>

                            @if(current_user()->coffee_shop->id === $coffeeShop->id)
                                <a href="#" id="edit-coffeeshop-about-helper">Change description</a>
                                <p id="edit-coffeeshop-about"
                                   data-target="{{ route('coffee-shop.update', ['coffeeShop' => $coffeeShop]) }}">
                            @else
                                <p>
                            @endif
                                {{ ! $coffeeShop->about ? 'No information.' : $coffeeShop->about }}
                            </p>
                        </div>

                        <div class="col-xs-6">
                            <h4>Current deals</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Location</h4>

                            MAPS
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ elixir('js/shop_owner.js') }}"></script>
@endsection
