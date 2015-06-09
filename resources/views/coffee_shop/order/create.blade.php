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
                           type="text"
                           placeholder="12:34"
                           class="form-control"
                           value="{{old('time', $order->time)}}">
                </div>

                <div class="form-group @if($errors->any()) {{$errors->has('products') ? 'has-error' : 'has-success'}} @endif">
                    <h5>Products:</h5>
                    <label class="row full-width">
                        @if($orderProduct !== null)
                            <span class="col-xs-12 col-sm-6">
                                <select id="product-1" name="products[]" class="form-control">
                                    @foreach($products as $product)
                                        <option @if($orderProduct->id == $product->id) selected @endif
                                        value="{{ $product->id }}" data-type="{{ $product->type }}">
                                            {{ $coffeeShop->getNameFor($product) }}
                                        </option>
                                    @endforeach
                                </select>
                            </span>
                            <span class="col-xs-12 col-sm-6">
                                @if($orderProduct->type == 'drink')
                                    <select id="productSize-1" name="productSizes[]" class="form-control">
                                        @foreach(['xs', 'sm', 'md', 'lg'] as $size)
                                            @if($coffeeShop->hasActivated($orderProduct, $size))
                                                <option value="{{ $size }}">
                                                    {{$coffeeShop->getSizeDisplayName($size)}} (£ {{$orderProduct->pivot->$size / 100}})
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <p class="info-price">
                                        Price: £ {{$orderProduct->pivot->sm}}
                                    </p>
                                @endif
                            </span>
                        @else
                            <span class="col-xs-12 col-sm-6">
                                <select id="product-1" name="products[]" class="form-control">
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
                        @endif

                    </label>
                    <a href="#" class="row" id="add-product">Add a product</a>
                </div>

                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                <button type="submit" class="btn btn-success">Proceed to checkout</button>
            </form>
        </div>
    </div>
</div>
@stop

<script type="text/javascript">
    var products = {!! json_encode($products) !!};
    var coffeeShop = {!! $coffeeShop->toJson() !!};
</script>
