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
                <form action="{{ route('offers.store') }}" class="form-horizontal">
                    <div class="form-group @if($errors->any()) {{$errors->has('product') ? 'has-error' : 'has-success'}} @endif">
                        <label for="product" class="col-sm-2 control-label">Product:</label>

                        <div class="col-sm-10 col-md-6">
                            <select id="product" name="product" class="form-control">
                                <option value="" selected></option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $coffeeShop->getNameFor($product) }}</option>
                                @endforeach
                            </select>
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
                        </div>
                    </div>

                    <div class="offer-details">
                        <h3>Offer details</h3>
                        <div class="form-group @if($errors->any()) {{$errors->has('referenced_product') ? 'has-error' : 'has-success'}} @endif">
                            <label for="referenced_product" class="col-sm-2 control-label">Referenced product (opt):</label>
                            <div class="col-sm-10 col-md-6">
                                <select id="referenced_product" name="referenced_product[0]" class="form-control">
                                    <option value="" selected></option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $coffeeShop->getNameFor($product) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="radio col-sm-10 col-md-6 col-sm-offset-2 col-md-offset-2">
                                <label>
                                    <input type="radio" name="type[0]" value="free">
                                    The referenced product will be free.
                                </label>
                            </div>
                            <div class="radio col-sm-10 col-md-6 col-sm-offset-2 col-md-offset-2">
                                <label>
                                    <input type="radio" name="type[0]" value="flat">
                                    The referenced product will be reduced by a fixed amount.
                                    You can specify the amount below, for each size (if it is a drink).
                                </label>
                            </div>
                            <div class="radio col-sm-10 col-md-6 col-sm-offset-2 col-md-offset-2">
                                <label>
                                    <input type="radio" name="type[0]" value="percent" checked>
                                    The referenced product will be reduced by a percentage.
                                    You can specify the amount below, for each size (if it is a drink).
                                </label>
                            </div>
                        </div>

                        <div class="sizes"></div>
                    </div>
                    <div class="form-group">
                        <a href="#" id="add-offer-detail" class="col-sm-10 col-sm-offset-2">Add offer detail</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
