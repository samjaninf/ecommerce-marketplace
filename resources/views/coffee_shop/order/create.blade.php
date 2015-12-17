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

            <div class="order_header col-xs-12 col-sm-8 col-md-8 col-lg-6 col-sm-offset-2 col-md-offset-2 col-lg-offset-3">
                <h2>Place Your Order</h2>
            </div>
        </div>
    </div>
</div>
<div id="order">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 col-sm-offset-2 col-md-offset-2 col-lg-offset-3" id="order-inner">
                <form action="{{ route('coffee-shop.order.store', ['coffeeShop' => $coffeeShop]) }}" method="post">

                    <div class="form-group @if($errors->any()) {{$errors->has('time') ? 'has-error' : 'has-success'}} @endif">
                        <div class="order_left">
                            <span class="number"> 1.</span>
                        </div>
                        <div class="order_right">
                            <p class="opening">
                              <span class="alt-txt">Opening Times: </span>{!! nl2br(e($coffeeShop->showOpeningTimes())) !!}
                            </p>
                            <select id="time" name="time" class="form-control">
                                @foreach ( $times as $string => $time )
                                    <option value="{{ $time }}">{{ $string }}</option>
                                @endforeach
                                    <option value="00:00">Make when I arrive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group order-products @if($errors->any()) {{$errors->has('products') ? 'has-error' : 'has-success'}} @endif">
                        <div class="order_left">
                             <span class="number"> 2.</span> 
                        </div>
                        <div class="order_right">
                            <p class="section-header"> Confirm your drinks orders below: </p>
                            <h5 @if($coffeeShop->products()->wherePivot('description', '!=', '')->whereNotNull('description')->count() == 0) class="hide" @endif>
                                Products: <a href="#" onclick="showMenuDescription(this)">View menu description</a>
                            </h5>
                            <div class="product_header row">
                                <div class="col-xs-6">
                                    Drink:
                                </div>
                                <div class="col-xs-6">
                                    Size:
                                </div>
                            </div>
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
                                            <select id="product-drink-[0]" name="products[0]" class="form-control choose-product-select">
                                                @foreach($products as $product)
                                                    @if($coffeeShop->hasActivated($product))
                                                        @if($product->type == 'drink')
                                                            <option class="drink-option" value="{{ $product->id }}" data-type="{{ $product->type }} @if($orderProduct->id == $product->id) selected @endif">
                                                                {{ $coffeeShop->getNameFor($product) }}
                                                            </option>
                                                        @else
                                                            <option class="food-option" value="{{ $product->id }}" data-type="{{ $product->type }}">
                                                                {{ $coffeeShop->getNameFor($product) }}
                                                            </option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select> 
                                        </span>
                                        <span class="col-xs-12 col-sm-5 sizes-select">

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
                            <a href="#" class="row btn btn-primary" id="add-product">Add Drink</a>
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
                        <a href="{{ route('coffee-shop.show', [ $coffeeShop->id ]) }}" class="btn btn-primary back-to-shop col-xs-4">Go Back</a>
                        <button type="submit" class="btn btn-success proceed-to-checkout col-xs-7 col-xs-offset-1">Place Order & Pay</button>
                    </div>
                </form>
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
