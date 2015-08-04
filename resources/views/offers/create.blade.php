@extends('app')

@section('page-title')
    Adding an offer
@stop

@section('content')
    <div class="container" id="creating-offers">
        <div class="row">
            <div class="col-xs-12">
                <h1>@yield('page-title')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-info">
                    <h4>Examples:</h4>
                    <p>
                        <b>Product:</b> Americano<br>
                        <b>Until:</b> {{ \Carbon\Carbon::now()->addWeek()->endOfWeek()->format('d-m-Y') }}<br>
                        <b>Reduced product:</b> Brownie<br>
                        <b>FIXED AMOUNT:</b> £0.50<br>

                        <i>When a user buys an americano, they have a reduction of 50p on the brownie.</i>
                    </p>

                    <p>
                        <b>Product:</b> Latte<br>
                        <b>Until:</b> {{ \Carbon\Carbon::now()->addWeek()->endOfWeek()->format('d-m-Y') }}<br>
                        <b>Reduced product:</b> /<br>
                        <b>PERCENTAGE:</b> 20%<br>

                        <i>When a user buys a latte, it is reduced by 20%.</i>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <form action="{{ route('offers.store') }}" method="post" class="form-horizontal">
                    <div class="form-group @if($errors->any()) {{$errors->has('product') ? 'has-error' : 'has-success'}} @endif">
                        <label for="product" class="col-sm-2 control-label">Product:</label>

                        <div class="col-sm-10 col-md-6">
                            <select id="product" name="product" class="form-control">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $coffeeShop->getNameFor($product) }}</option>
                                @endforeach
                            </select>

                            <p class="help-block">
                                When a customer add this product to their order,
                                the offer will activate (if they chose it).
                            </p>
                        </div>
                    </div>

                    <div class="form-group @if($errors->any()) {{$errors->has('finish_at') ? 'has-error' : 'has-success'}} @endif">
                        <label for="finish_at" class="col-sm-2 control-label">Until:</label>
                        <div class="col-sm-10 col-md-6">
                            <input id="finish_at"
                                   name="finish_at"
                                   type="date"
                                   placeholder="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"
                                   class="form-control"
                                   value="{{old('finish_at')}}">

                            <p class="help-block">
                                The offer will become unavailable after this date.
                            </p>
                        </div>
                    </div>

                    <div id="offer-details">
                        <h3>Offer details</h3>

                        <div class="form-group @if($errors->any()) {{$errors->has('referenced_product') ? 'has-error' : 'has-success'}} @endif">
                            <label for="referenced_product-0" class="col-sm-2 control-label">
                                Reduced product (opt):
                            </label>

                            <div class="col-sm-10 col-md-6">
                                <select id="referenced_product-0"
                                        name="referenced_product[0]"
                                        class="form-control">
                                    <option value="" selected></option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $coffeeShop->getNameFor($product) }}</option>
                                    @endforeach
                                </select>
                                <p class="help-block">
                                    If you leave this field empty, the offer will apply on the product above.
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="radio col-sm-10 col-md-6 col-sm-offset-2 col-md-offset-2">
                                <label>
                                    <input type="radio" name="type[0]" value="free" checked>
                                    FREE: The reduced product will be free.
                                </label>
                            </div>
                            <div class="radio col-sm-10 col-md-6 col-sm-offset-2 col-md-offset-2">
                                <label>
                                    <input type="radio" name="type[0]" value="flat">
                                    FIXED AMOUNT: The product will be reduced by a fixed amount.
                                    You can specify the amount below, for each size (if it is a drink).
                                </label>
                            </div>
                            <div class="radio col-sm-10 col-md-6 col-sm-offset-2 col-md-offset-2">
                                <label>
                                    <input type="radio" name="type[0]" value="percent">
                                    PERCENTAGE: The product will be reduced by a percentage.
                                    You can specify the amount below, for each size (if it is a drink).
                                </label>
                            </div>
                        </div>

                        <div class="sizes" id="sizes-0">
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <a href="#" id="add-offer-detail">Add offer detail</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-2">
                            <input type="submit" class="btn btn-success" value="Add this offer">
                        </div>
                        <div class="col-sm-4">
                            <p class="well well-sm">The offer will be available immediately.</p>
                        </div>
                    </div>

                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                </form>
            </div>
        </div>
    </div>
@stop

<script type="text/javascript">
    var products = {!! json_encode($products) !!};
    var coffeeShop = {!! json_encode($coffeeShop) !!};
</script>
