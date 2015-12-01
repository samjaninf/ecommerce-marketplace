@extends('app')

@section('page-title')
    Place an order for {{$coffeeShop->name}}
@stop

@section('content')
<div id="order-top" style="background-image: url('{{ $coffeeShop->mainImage() }}')">
    <div class="order-top-overlay">
    </div>
    <div class="container"> 
        <div class="row">
            <h1 class="shop_name"> {{$coffeeShop->name}}
            <h3> <span class="glyphicon glyphicon-map-marker"> </span> {{$coffeeShop->location}} </h3>
            <span class="ratings">
                @include('coffee_shop._rating', ['rating' => $coffeeShop->getRating()])
            </span>

            <div class="order_header col-xs-12 col-sm-6  col-sm-offset-6 col-md-offset-6 col-lg-offset-6">
                <h2>Place Your Order</h2>
            </div>
        </div>
    </div>
</div>
<div id="order">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                  <div class="row">
                        <div class="review-container">
                                    <div class="review">
                                        @if($bestReview !== null)
                                            {{$bestReview->pivot->review === '' ? 'No comment' : $bestReview->pivot->review}}
                                        @else
                                            No review has been written yet!
                                        @endif
                                    </div>
                                </div>
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
                                    You can only select 5 styles at most.
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
            </div>
            <div class="col-xs-12 col-sm-6 " id="order-inner">
                <form action="{{ route('coffee-shop.order.store', ['coffeeShop' => $coffeeShop]) }}" method="post">

                    <div class="form-group @if($errors->any()) {{$errors->has('time') ? 'has-error' : 'has-success'}} @endif">
                        <div class="order_left">
                            <span class="number"> 1.</span> 
                        </div>
                        <div class="order_right">
                            <p class="section-header">Set a collection time or tick to ‘make on arrival’ if you’re not sure when you will arrive: </p>
                            <input id="time"
                                   name="time"
                                   placeholder="12:34"
                                   class="form-control"
                                   value="{{old('time', $order->time->format('H:i'))}}"
                                   type="text"
                                   data-field="time"
                                   readonly
                                   style="cursor:pointer;">

                            <p class="opening">
                              <span class="alt-txt">Opening Times: </span>{!! nl2br(e($coffeeShop->showOpeningTimes())) !!}
                            </p>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  name="make_on_arriving"> Make when I arrive
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group order-products @if($errors->any()) {{$errors->has('products') ? 'has-error' : 'has-success'}} @endif">
                        <div class="order_left">
                             <span class="number"> 2.</span> 
                        </div>
                        <div class="order_right">
                            <p class="section-header"> Select your drinks orders below: </p>
                            <h5 @if($coffeeShop->products()->wherePivot('description', '!=', '')->whereNotNull('description')->count() == 0) class="hide" @endif>
                                Products: 
                            </h5>

                            <div class="well well-sm hide" id="menu-description">
                                <dl>
                                    @foreach($coffeeShop->products as $product)
                                        @if($coffeeShop->hasActivated($product) && !empty($product->pivot->description))
                                            <dt>{{ $coffeeShop->getNameFor($product) }}</dt>
                                            <dd>{{ $coffeeShop->getDisplayDescriptionFor($product) }}</dd><br>
                                        @endif
                                    @endforeach
                                </dl>
                            </div>
                            @if(!$orderProducts->isEmpty())
                                @foreach($orderProducts as $i => $orderProduct)
                                    <label class="row full-width" style="margin-top: 10px">
                                        <span class="col-xs-12 col-sm-6">
                                            <select id="product-{{ $i }}" name="products[{{$i}}]" class="form-control choose-product-select">
                                                @foreach($products as $product)
                                                    @if($coffeeShop->hasActivated($product))
                                                        <option @if($orderProduct->id == $product->id) selected @endif
                                                        value="{{ $product->id }}" data-type="{{ $product->type }}">
                                                            {{ $coffeeShop->getNameFor($product) }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </span>
                                        <span class="col-xs-12 col-sm-5">
                                            @if($orderProduct->type == 'drink')
                                                <span class="sizes">
                                                    <select class="form-control" name="productSizes[{{ $i }}]">
                                                        @foreach(['xs', 'sm', 'md', 'lg'] as $size)
                                                            @if($coffeeShop->hasActivated($orderProduct, $size))
                                                                <option value="{{ $size }}">
                                                                    {{$coffeeShop->getSizeDisplayName($size)}}
                                                                    (£ {{$orderProduct->pivot->$size / 100}})
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </span>
                                            @else
                                                <p class="info-price">
                                                    Price: £ {{$orderProduct->pivot->sm}}
                                                </p>
                                            @endif
                                        </span>
                                        <span class="col-xs-12 col-sm-1">
                                            <a href="#" class="btn btn-danger remove-product form-control" id="remove-product-{{$i}}">×</a>
                                        </span>
                                    </label>
                                @endforeach
                            @else
                                <label class="row full-width" style="margin-top: 10px">
                                    <span class="col-xs-12 col-sm-6">
                                        <select id="product-0" name="products[0]" class="form-control choose-product-select">
                                            <option value=""></option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-type="{{ $product->type }}">
                                                    {{ $coffeeShop->getNameFor($product) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </span>
                                    <span class="col-xs-12 col-sm-5">
                                        <span></span>
                                    </span>
                                    <span class="col-xs-12 col-sm-1">
                                        <a href="#" class="btn btn-danger remove-product form-control" id="remove-product-0">×</a>
                                    </span>
                                </label>
                            @endif
                            <a href="#" class="row" id="add-product">Add Product</a>
                        </div>
                    </div>

                    @if(Session::has('offer-used'))
                    <p class="offers alert alert-info">
                        Chosen Offer:<br>
                        {{ display_offer(Session::get('offer-used')) }}
                    </p>
                    @endif

                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                 
                    <div class="col-xs-12 col-sm-12 btn-panel ">
                        <button type="submit" class="btn btn-success proceed-to-checkout col-xs-12">Place Order</button>
                    </div>
                </form>
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
                <div class="col-xs-12 col-sm-12 col-md-12">
                  
                    <hr>
                    <div class="row">
                        <div class="col-xs-12" id="show-coffee-shop-offers">
                            <h4>Current deals</h4>

                            <div class="row">
                                @if($coffeeShop->offer_activated)
                                    <div class="col-xs-12 col-sm-6">
                                        @include('offers._short', ['offer' => $coffeeShop, 'bgNum' => rand(1,4)])
                                    </div>
                                @endif
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

                                @if(! Auth::guest())
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
                                    @elseif($coffeeShop->reviews->count() == 0)
                                        Awaiting Reviews
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

<script type="text/javascript">
    var products = {!! json_encode($products) !!};
    var coffeeShop = {!! $coffeeShop->toJson() !!};

    function showMenuDescription(el) {
        event.preventDefault();
        document.getElementById('menu-description').classList.remove('hide');
        el.parentNode.removeChild(el)
    }
</script>
