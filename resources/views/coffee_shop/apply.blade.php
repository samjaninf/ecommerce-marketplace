@extends('app')

@section('page-title')
    Have your shop in our list
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            @include('shared/_form_errors')
            <form class="form-horizontal" method="post" action="{{ route('coffee_shop.applied') }}">
                <div class="form-group @if($errors->any()) {{$errors->has('name') ? 'has-error' : 'has-success'}} @endif">
                    <label for="name" class="col-sm-2 control-label">Name:</label>

                    <div class="col-sm-10">
                        <input id="name"
                               name="name"
                               type="text"
                               placeholder="The name of your coffee shop..."
                               class="form-control"
                               value="{{old('name', $coffeeShop->name)}}">
                    </div>
                </div>

                <div class="form-group @if($errors->any()) {{$errors->has('location') ? 'has-error' : 'has-success'}} @endif">
                    <label for="field-maps-location" class="col-sm-2 control-label">Address:</label>

                    <div class="col-sm-10">
                        <input id="field-maps-location"
                               name="location"
                               type="text"
                               placeholder="The address of your coffee shop..."
                               class="form-control"
                               value="{{old('location', $coffeeShop->location)}}">
                    </div>
                </div>

                <div class="form-group @if($errors->any()) {{$errors->has('postal_code') ? 'has-error' : 'has-success'}} @endif">
                    <label for="postal_code" class="col-sm-2 control-label">Postal code:</label>

                    <div class="col-sm-10">
                        <input id="postal_code"
                               name="postal_code"
                               type="text"
                               placeholder="Postal code..."
                               class="form-control"
                               value="{{old('postal_code', $coffeeShop->postal_code)}}">
                    </div>
                </div>

                <div class="form-group @if($errors->any()) {{$errors->has('comment') ? 'has-error' : 'has-success'}} @endif">
                    <label for="comment" class="col-sm-2 control-label">Comment:</label>

                    <div class="col-sm-10">
                        <textarea id="comment"
                                  name="comment"
                                  placeholder="Anything particular to say?"
                                  class="form-control">{{old('comment', $coffeeShop->comment)}}</textarea>
                    </div>
                </div>

                <input type="hidden" name="latitude" value="" id="latitude-field">
                <input type="hidden" name="longitude" value="" id="longitude-field">
                <input type="hidden" name="place_id" value="" id="place-id-field">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-primary" value="Send your request">
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div id="maps-container" @if(isset($position)) data-position="{{$position}}" @endif></div>
        </div>
    </div>
</div>
@endsection

@section('vendor_scripts')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ elixir('js/gmaps.js')}}"></script>
@endsection
