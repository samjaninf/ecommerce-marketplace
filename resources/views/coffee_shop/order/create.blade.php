@extends('app')

@section('page-title')
    Place an order for {{$coffeeShop->name}}
@stop

@section('content')
    <img src="{{$coffeeShop->mainImage()}}" alt="{{ $coffeeShop->name }}" style="width: 100%; height: 400px">
    <div class="container" id="order">
    <div class="row">
        <div class="col-xs-12">
            <h1>
                Place an order for <i>{{$coffeeShop->name}}</i>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('coffee-shop.order.store', ['coffeeShop' => $coffeeShop]) }}" method="post">
                <div class="form-group @if($errors->any()) {{$errors->has('time') ? 'has-error' : 'has-success'}} @endif">
                    <label for="time">Pickup time:</label>
                    <input id="time"
                           name="time"
                           type="time"
                           step="60"
                           placeholder="12:34"
                           class="form-control"
                           value="{{old('time', $order->time->format('H:i'))}}">

                    <p>
                        {!! nl2br(e($coffeeShop->showOpeningTimes())) !!}
                    </p>
                </div>

                <div class="form-group order-products @if($errors->any()) {{$errors->has('products') ? 'has-error' : 'has-success'}} @endif">
                    <h5>
                        Products: <a href="#" onclick="showMenuDescription(this)">View menu description</a>
                    </h5>

                    <div class="well well-sm hide" id="menu-description">
                        <dl>
                            @foreach($coffeeShop->products as $product)
                                @if($coffeeShop->hasActivated($product))
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
                                            @foreach(['xs', 'sm', 'md', 'lg'] as $size)
                                                @if($coffeeShop->hasActivated($orderProduct, $size))
                                                    <label class="radio-inline">
                                                        <input type="radio" name="productSizes[{{$i}}]" value="{{$size}}">
                                                        {{$coffeeShop->getSizeDisplayName($size)}}
                                                        (£ {{$orderProduct->pivot->$size / 100}})
                                                    </label>
                                                @endif
                                            @endforeach
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
                    <a href="#" class="row" id="add-product">Add a product</a>
                </div>

                @if(Session::has('offer-used'))
                <p class="offers alert alert-info">
                    Chosen offer:<br>
                    {{ display_offer(Session::get('offer-used')) }}
                </p>
                @endif

                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                <button type="submit" class="btn btn-success proceed-to-checkout">Proceed to checkout</button>
            </form>
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
