@extends('app')

@section('page-title')
    Place an order for {{$coffeeShop->name}}
@stop

@section('content')
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
                           placeholder="12:34"
                           class="form-control"
                           value="{{old('time', $order->time->format('H:i'))}}">
                </div>

                <div class="form-group order-products @if($errors->any()) {{$errors->has('products') ? 'has-error' : 'has-success'}} @endif">
                    <h5>Products:</h5>
                    <a href="#" onclick="showMenuDescription(this)">View menu description</a>

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
                            </label>
                        @endforeach
                    @else
                        <label class="row full-width" style="margin-top: 10px">
                            <span class="col-xs-12 col-sm-6">
                                <select id="product-1" name="products[0]" class="form-control choose-product-select">
                                    <option value=""></option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-type="{{ $product->type }}">
                                            {{ $coffeeShop->getNameFor($product) }}
                                        </option>
                                    @endforeach
                                </select>
                            </span>
                            <span class="col-xs-12 col-sm-6">
                                <span></span>
                            </span>
                        </label>
                    @endif
                    <a href="#" class="row" id="add-product">Add a product</a>
                </div>

                <p class="offers">
                    Current offer applying:<br>
                    {{ Session::has('offer-used') ? display_offer(Session::get('offer-used')) : "" }}
                </p>

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
