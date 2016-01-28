@extends('app')

@section('page-title')
    Have your shop in our list
@endsection

@section('content')
<div style="padding: 0px;" class="container-fluid">
  <div class="row" id="apply-title">
    <div class="col-xs-12 list-your-shop-overlay">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-offset-2 col-sm-8">
            <h1 class="text-center signup-header">
              Join KoolBeans for free & allow customers to discover your coffee shop & order ahead
            </h1>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid" id="coffee-shop-benefits">
    <div class="row row-eq-height text-center">
        <div class="col-xs-12 col-sm-3">
            <img src="/img/increase customers.png"/>
            <h4>More customers</h4>
            <p>Ordering ahead allows you to serve more customers as orders and payments are taken in advance.</p>
        </div>
        <div class="col-xs-12 col-sm-3">
            <img src="/img/Increase sales.png"/>
            <h4>Higher average spends</h4>
            <p>Online purchases have a higher average spend as customers take more time browsing your shop.</p>
        </div>
        <div class="col-xs-12 col-sm-3">
            <img src="/img/Customer icon 2.png"/>
            <h4>Customer satisfaction</h4>
            <p>80% of coffee consumers would prefer to order ahead than lose out because of a large queue.</p>
        </div>
        <div class="col-xs-12 col-sm-3 ">
            <img src="/img/mobile review.png"/>
            <h4>Trusted reviews</h4>
            <p>Our service only allows reviews from customers who have actually bought from you.</p>
        </div>
    </div>
</div>
<div class="container-fluid" id="apply-whatwedo">
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 text-center">
          <img style="width: 100%; padding: 10px 0px; max-width: 800px;" src="/img/welcome/fees.png" title="Fee's" alt="fee"/>
          <h1 style="border-bottom: 0px;">Full sales amount less fees paid directly to your account</h1>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container main-content-padded">
    <div class="row" style="margin-top:20px">
      <div class="col-md-12 col-lg-8">
         <h4 class="text-center">View our <a href="/signup-faq">FAQ's</a></h4>
      </div>
      <div class="col-xs-4 hidden-md hidden-sm hidden-xs">
        <h4 class="text-center">Drag pin to your location!</h4>
      </div>
    </div>
    <div class="row" style="margin-top: 20px">
        
            @include('shared/_form_errors')
            <form class="form-horizontal" method="post" action="{{ route('coffee-shop.applied') }}">
              <div class="col-lg-8">
                @if(Auth::guest())
                    <div class="form-group @if($errors->any()) {{$errors->has('username') ? 'has-error' : 'has-success'}} @endif">
                        <label for="username" class="col-sm-3 control-label"><span class="col-accent">1.</span> Your name:</label>

                        <div class="col-sm-9">
                            <input id="username"
                                   name="username"
                                   type="text"
                                   placeholder="John Smith"
                                   class="form-control"
                                   value="{{old('name')}}">
                        </div>
                    </div>
                @endif

                <div class="form-group @if($errors->any()) {{$errors->has('name') ? 'has-error' : 'has-success'}} @endif">
                    <label for="name" class="col-sm-3 control-label"><span class="col-accent">2.</span> Coffee shop name:</label>

                    <div class="col-sm-9">
                        <input id="name"
                               name="name"
                               type="text"
                               placeholder="The name of your coffee shop..."
                               class="form-control"
                               value="{{old('name', $coffeeShop->name)}}">
                    </div>
                </div>

                @if(Auth::guest())
                    <div class="form-group @if($errors->any()) {{$errors->has('email') ? 'has-error' : 'has-success'}} @endif">
                        <label for="email" class="col-sm-3 control-label"><span class="col-accent">3.</span> E-Mail Address</label>

                        <div class="col-sm-9">
                            <input type="email"
                                   class="form-control"
                                   placeholder="email@domain.com"
                                   name="email"
                                   value="{{ old('email') }}"
                                   id="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="col-sm-3 control-label"><span class="col-accent">4.</span> Confirm Password</label>

                        <div class="col-sm-9">
                            <input type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   id="password_confirmation">
                        </div>
                    </div>

                @endif

                <div class="form-group @if($errors->any()) {{$errors->has('location') ? 'has-error' : 'has-success'}} @endif">
                    <label for="field-maps-location" class="col-sm-3 control-label"><span class="col-accent">5.</span> Address:</label>

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
                    <label for="postal_code" class="col-sm-3 control-label"><span class="col-accent">6.</span> Postal code:</label>

                    <div class="col-sm-9">
                        <input id="postal_code"
                               name="postal_code"
                               type="text"
                               placeholder="Postal code..."
                               class="form-control"
                               value="{{old('postal_code', $coffeeShop->postal_code)}}">
                    </div>
                </div>

                .
                <div class="form-group @if($errors->any()) {{$errors->has('county') ? 'has-error' : 'has-success'}} @endif">
                    <label for="county" class="col-sm-3 control-label"><span class="col-accent">7.</span> County:</label>

                    <div class="col-sm-9 col-md-6">
                        <input id="county"
                               name="county"
                               type="text"
                               placeholder="County..."
                               class="form-control"
                               value="{{old('county', $coffeeShop->county)}}">
                    </div>
                </div>

                <div class="form-group @if($errors->any()) {{$errors->has('phone_number') ? 'has-error' : 'has-success'}} @endif">
                    <label for="phone_number" class="col-sm-3 control-label"><span class="col-accent">8.</span> Phone number:</label>

                    <div class="col-sm-9 col-md-6">
                        <input id="phone_number"
                               name="phone_number"
                               type="text"
                               placeholder="Phone number..."
                               class="form-control"
                               value="{{old('phone_number', $coffeeShop->phone_number)}}">
                    </div>
                </div>

                <div class="form-group @if($errors->any()) {{$errors->has('comment') ? 'has-error' : 'has-success'}} @endif">
                    <label for="comment" class="col-sm-3 control-label"><span class="col-accent">9.</span> Comment:</label>

                    <div class="col-sm-9">
                        <textarea id="comment"
                                  name="comment"
                                  placeholder="Do you have any questions for Koolbeans?"
                                  class="form-control">{{old('comment', $coffeeShop->comment)}}</textarea>
                    </div>
                </div>

                <div class="form-group @if($errors->any()) {{$errors->has('terms') ? 'has-error' : 'has-success'}} @endif">
                    <label for="terms" class="col-sm-3 control-label"><span class="col-accent">10.</span> T&C:</label>

                    <div class="col-sm-9 col-md-6">
                      <div class="checkbox">
                        <label>
                        <input id="terms"
                               name="terms"
                               type="checkbox"> Please tick the box to agree to our <a href="/coffee-shop-contract" target="_blank">Terms and Conditions</a>
                        </label>
                      </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('g-recaptcha-response')) has-errors @endif">
                    <label for="recaptcha" class="col-sm-3 control-label">Robot verification:</label>

                    <div class="col-sm-9">
                        <div id="recaptcha"
                             class="g-recaptcha"
                             data-sitekey="6LdFiAcTAAAAAIbzqXSusUhI7FKB6IuZT6tKYLJP"></div>
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

        </div>

        <div class="col-lg-4 col-xs-12">
            <div class="hidden-lg visible-md visible-sm visible-xs text-center">
              <h4>Drag pin to your location!</h4>
            </div>
            <div id="maps-container" class="draggable-marker" @if(isset($position)) data-position="{{$position}}" @endif></div>
            <p class="help-block">You can drag the pin to be more accurate.</p>
        </div>
          <div class="col-xs-12">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <input type="submit" class="btn btn-primary" value="Register your coffee shop">
                </div>
            </div>
          </div>
        </form>
    </div>
</div>
@endsection

@section('vendor_scripts')
    <script type="text/javascript" src="//www.google.com/recaptcha/api.js"></script>
    <script>
      $('#content').css('background','#ebebeb')
    </script> 
@endsection
