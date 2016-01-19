@extends('app')

@section('page-title')
    Your coffee shop
@endsection

@section('content')
    <div class="container-fluid">
        @include('dashboard._header')
        <div class="row">
            <div class="col-sm-3">
                @include('dashboard._menu')
            </div>

            <div class="row">
                @if($errors->any())
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    {{$error}}<br>
                                @endforeach
                            </p>
                        </div>
                    </div>
                @endif


                <div class="col-xs-12 col-lg-6">
                    <h1 class="text-center">Update your profile!</h1>

                    <h2><a target="_blank" href="{{ route('coffee-shop.opening-times') }}">Change your opening times</a></h2>

                    <form class="form-horizontal" action="{{ route('my.profile.update') }}" method="post">

                        <div class="form-group @if($errors->any()) {{$errors->has('name') ? 'has-error' : 'has-success'}} @endif">
                            <label for="name" class="col-sm-2">Coffee shop name:</label>

                            <div class="col-sm-9">
                                <input id="name"
                                       name="name"
                                       type="text"
                                       placeholder="The name of your coffee shop..."
                                       class="form-control"
                                       value="{{old('name', $coffeeShop->name)}}">
                            </div>
                        </div>
                       <div class="form-group @if($errors->any()) {{$errors->has('location') ? 'has-error' : 'has-success'}} @endif">
                            <label for="field-maps-location" class="col-sm-2">Address:</label>

                            <div class="col-sm-9">
                                <input id="field-maps-location"
                                       name="location"
                                       type="text"
                                       placeholder="The address of your coffee shop..."
                                       class="form-control"
                                       value="{{old('location', $coffeeShop->location)}}">
                            </div>
                        </div>

                        <div class="form-group @if($errors->any()) {{$errors->has('postal_code') ? 'has-error' : 'has-success'}} @endif">
                            <label for="postal_code" class="col-sm-2">Postal code:</label>

                            <div class="col-sm-9">
                                <input id="postal_code"
                                       name="postal_code"
                                       type="text"
                                       placeholder="Postal code..."
                                       class="form-control"
                                       value="{{old('postal_code', $coffeeShop->postal_code)}}">
                            </div>
                        </div>

                        
                        <div class="form-group @if($errors->any()) {{$errors->has('county') ? 'has-error' : 'has-success'}} @endif">
                            <label for="county" class="col-sm-2">County:</label>

                            <div class="col-sm-9">
                                <input id="county"
                                       name="county"
                                       type="text"
                                       placeholder="County..."
                                       class="form-control"
                                       value="{{old('county', $coffeeShop->county)}}">
                            </div>
                        </div>

                        <div class="col-lg-12 col-xs-12">
                            <div class="text-center">
                              <h4>Not the correct location? Drag the pin to your coffee shop.</h4>
                            </div>
                            <div id="maps-container" class="draggable-marker" data-position="{{ $coffeeShop->latitude }}, {{ $coffeeShop->longitude }}"></div>
                            <p class="help-block">You can drag the pin to be more accurate.</p>
                        </div>

                        <div class="form-group @if($errors->any()) {{$errors->has('phone_number') ? 'has-error' : 'has-success'}} @endif">
                            <label for="phone_number" class="col-sm-2">Phone number:</label>

                            <div class="col-sm-9">
                                <input id="phone_number"
                                       name="phone_number"
                                       type="text"
                                       placeholder="Phone number..."
                                       class="form-control"
                                       value="{{old('phone_number', $coffeeShop->phone_number)}}">
                            </div>
                        </div>
                        <input type="hidden"
                               name="latitude"
                               value="{{old('latitude', $coffeeShop->latitude)}}"
                               id="latitude-field">
                        <input type="hidden"
                               name="longitude"
                               value="{{old('longitude', $coffeeShop->longitude)}}"
                               id="longitude-field">
                        <input type="hidden"
                               name="place_id"
                               value="{{old('place_id', $coffeeShop->place_id)}}"
                               id="place-id-field">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">

                        <div class="form-group">
                            <div class="col-sm-9">
                                <input type="submit" class="btn btn-lg btn-primary" value="Update your coffee shop">
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
