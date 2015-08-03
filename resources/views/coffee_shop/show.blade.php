@extends('app')

@section('page-title')
    {{$coffeeShop->name}}
@endsection

@section('content')
    <div id="coffee-shop-presentation">
        <div class="container-fluid" id="show-coffee-shop">
            <div class="row">
                {{--<div class="col-xs-12" id="coffee-shop-image" style="background-image: url({{$coffeeShop->mainImage()}})">--}}
                {{--</div>--}}
                <img class="col-xs-12" id="coffee-shop-image"
                     src="/uploads/500fbe0a8348e91f731a914bb45cab4efce2c68d/2015_08_03_125107.png"
                     style="padding: 0">
            </div>
        </div>

        <div id="best-review-and-features-available">
            <div class="container" id="coffee-shop-info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-9" id="coffee-shop-presentation-title">
                        <h1>@yield('page-title')</h1>
                        <h3>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            {{$coffeeShop->location}}
                            <br class="hidden-lg">
                            <br class="hidden-lg">
                            <span class="ratings">
                                @include('coffee_shop._rating', ['rating' => $coffeeShop->getRating()])
                            </span>
                        </h3>
                    </div>
                    @if(Auth::guest() || !Auth::user()->owns($coffeeShop))
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading ">Order your coffee</div>
                            <div class="panel-body">
                                <form action="{{ route('coffee-shop.order.create', ['coffee_shop' => $coffeeShop]) }}">
                                    <label>
                                        <i class="fa fa-coffee"></i>
                                        <select name="id[]" class="panel-input">
                                            <option value="">Select your item</option>
                                            @foreach($coffeeShop->products as $product)
                                                @if($coffeeShop->hasActivated($product))
                                                    <option value="{{$product->id}}">{{$coffeeShop->getNameFor($product)}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </label>

                                    <a href="#" class="btn btn-default" id="add-another-item">Add another item</a>

                                    <label>
                                        <span class="glyphicon glyphicon-time"></span>
                                        <input class="panel-input"
                                               name="time"
                                               placeholder="{{\Carbon\Carbon::now()->format('H:i')}}">
                                    </label>

                                    <input type="submit" class="btn btn-success" value="Place order">
                                </form>
                            </div>
                            <div class="panel-footer">
                                <a href="{{ route('coffee-shop.order.create', ['coffee_shop' => $coffeeShop]) }}"
                                   class="btn btn-default view-full-menu">View full menu</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="container @if(Auth::check() && Auth::user()->owns($coffeeShop))cshop-owner @endif"
                 id="coffee-shop-description">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-9" style="z-index: 50">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="review-container">
                                    <div class="review">
                                        @if($bestReview !== null)
                                            {{$bestReview->pivot->review === '' ? 'No comment' : $bestReview->pivot->review}}
                                        @else
                                            No review has been written yet!
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 hidden-xs">
                                <div>
                                    @if(! Auth::guest() && current_user()->owns($coffeeShop))
                                        <a href="{{ route('coffee-shop.opening-times') }}">Change opening times</a>
                                    @endif
                                    <p>
                                        {!! nl2br(e($coffeeShop->showOpeningTimes())) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="coffee-shop-about">
            @if(! Auth::guest() && (current_user()->owns($coffeeShop) || current_user()->role === 'admin'))
                <div class="row">
                    <div class="col-xs-12">
                        @if(current_user()->role === 'admin')
                            <a href="{{ route('admin.coffee-shop.show', ['coffeeShop' => $coffeeShop]) }}" class="btn btn-primary">
                                Review performances
                            </a>
                        @else
                            <a href="{{ route('my-shop') }}" class="btn btn-primary">
                                Manage your shop
                            </a>
                            @if($coffeeShop->status === 'accepted')
                                <a href="{{ route('publish-my-shop') }}" class="btn btn-success">
                                    Publish your shop
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>About the shop</h4>

                            @if(! Auth::guest() && current_user()->owns($coffeeShop))
                                <a href="#" id="edit-coffeeshop-about-helper">Change description</a>
                                <p id="edit-coffeeshop-about"
                                   data-target="{{ route('coffee-shop.update', ['coffeeShop' => $coffeeShop]) }}">
                            @else
                                <p>
                                    @endif
                                    {{ ! $coffeeShop->about ? 'No information.' : $coffeeShop->about }}
                                </p>
                        </div>

                        <hr class="visible-xs-block">

                        <div class="col-sm-6 specs">
                            @if(! Auth::guest() && current_user()->owns($coffeeShop))
                                <h4 class="spec-actives">Active:</h4>
                                @foreach($coffeeShop->getSpecs() as $spec)
                                    @if($coffeeShop->{'spec_' . $spec})
                                        <a href="{{ route('coffee-shop.toggle-spec', ['coffee_shop' => $coffeeShop, 'spec' => $spec]) }}" class="toggle-spec">
                                            <img src="/img/coffee_shops/spec_{{$spec}}.png" alt="{{ $spec }}"/>
                                        </a>
                                    @endif
                                @endforeach

                                <h4 class="spec-inactives">Inactive:</h4>
                                @foreach($coffeeShop->getSpecs() as $spec)
                                    @if(!$coffeeShop->{'spec_' . $spec})
                                        <a href="{{ route('coffee-shop.toggle-spec', ['coffee_shop' => $coffeeShop, 'spec' => $spec]) }}" class="toggle-spec">
                                            <img src="/img/coffee_shops/spec_{{$spec}}.png" alt="{{ $spec }}"/>
                                        </a>
                                    @endif
                                @endforeach
                                <p class="well" style="margin-top: 10px;">
                                    Hint: Click on the icons to (de)activate them. <br>
                                    You can only select 5 attributes at most.
                                </p>
                            @else
                                @foreach($coffeeShop->getSpecs() as $spec)
                                    @if($coffeeShop->{'spec_' . $spec})
                                        <img src="/img/coffee_shops/spec_{{$spec}}.png" alt="{{$spec}}"/>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12" id="show-coffee-shop-offers">
                            <h4>Current deals</h4>

                            <div class="row">
                                @foreach($coffeeShop->offers as $i => $offer)
                                    <div class="col-xs-12 col-sm-6">
                                        @include('offers._short', ['bgNum' => ($i % 4) + 1])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Location</h4>

                            <div id="maps-container" data-position="{{$coffeeShop->getPosition()}}"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="reviews-for-coffeeshop">
                        <div class="col-xs-12">
                            <h4>
                                Reviews
                                @if(Session::has('special-message'))
                                    <p class="alert alert-{{key(Session::get('special-message'))}}"
                                       style="margin-top: 10px">
                                        {{current(Session::get('special-message'))}}
                                    </p>
                                @endif

                                @if(! Auth::guest() && current_user()->canReview($coffeeShop))
                                    @if ( ! $coffeeShop->reviews()->where('user_id', '=', current_user()->id)->count())
                                        <a href="#" id="add-review">
                                            Add your review
                                        </a>
                                    @endif
                                @endif
                            </h4>
                            <div class="row hide" id="add-review-form">
                                <div class="col-xs-12">
                                    <h5>Add your own review</h5>

                                    <p class="alert alert-danger hide" id="empty-rating">
                                        Heya, you forgot to give a rating!
                                    </p>
                                    <span class="ratings select-rating">
                                        Rating: @include('coffee_shop._rating', ['rating' => 0])
                                    </span>

                                    <form method="post"
                                          id="post-review"
                                          action="{{ route('coffee-shop.review', ['coffee_shop' => $coffeeShop]) }}">
                                        <div class="form-group">
                                            <textarea id="review"
                                                      name="review"
                                                      placeholder="Review..."
                                                      class="form-control"></textarea>
                                        </div>

                                        <input type="hidden" name="rating" value="" id="rating-input">
                                        <input type="hidden"
                                               name="_token"
                                               id="csrf-token"
                                               value="{{ Session::token() }}">

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Post review">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($coffeeShop->reviews as $i => $review)
                                    <div class="col-xs-12 col-sm-6 {{$i > 3 ? 'hide' : ''}} @if(Auth::user() && $review->id === current_user()->id) your-review @endif ">
                                        <div class="review-container">
                                            <div class="review">
                                                {{$review->pivot->review === '' ? "No comment" : $review->pivot->review }}
                                            </div>

                                            <div class="additional-details">
                                                {{$review->pivot->created_at->format('jS M Y')}}<br>

                                                <div class="author">
                                                    {{$review->name}}
                                                </div>
                                            </div>

                                            <span class="ratings">
                                                @include('coffee_shop._rating', ['rating' => $review->pivot->rating])
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-xs-12">
                                    @if($coffeeShop->reviews->count() > 3)
                                        <a href="#" id="show-more-reviews" class="hidden-xs">Show more...</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('vendor_scripts')
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
@stop

@section('scripts')
    <script>
        (function ($) {
            $('a#add-another-item').click(function () {
                var contents =
                    '<label><i class="fa fa-coffee"></i><select name="id[]" class="panel-input"><option value="">Select your item</option>' +
                        @foreach($coffeeShop->products as $product)
                            @if($coffeeShop->hasActivated($product))
                                '<option value="{{$product->id}}">{{$coffeeShop->getNameFor($product)}}</option>' +
                            @endif
                        @endforeach
                    '</select></i></label>';

                $(contents).insertBefore(this);
                return false;
            })
        })(jQuery);
    </script>
@stop
