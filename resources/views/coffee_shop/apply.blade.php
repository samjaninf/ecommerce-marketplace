@extends('app')

@section('page-title')
    Have your shop in our list
@endsection

@section('content')
<div class="container-fluid">
  <div class="row" id="apply-title">
    <div class="col-xs-12 list-your-shop-overlay">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-offset-2 col-sm-8">
            <h1 class="text-center signup-header">
              People are changing the way<br> they buy. So join them... 
            </h1>

            <h3 class="text-center">
                Joining the KoolBeans network of independent and small chain coffee shops is the easiest way to put your business online. We’ll have you listed in no time. 
            </h3>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid" id="coffee-shop-benefits">
    <div class="row row-eq-height text-center">
        <div class="col-xs-12 col-sm-3">
            <img src="/img/increase customers.png"/>
            <h4>Your Shop Online</h4>
            <p>Create your online coffee shop to match your business. Customise your page with photos, descriptions and menu</p>
        </div>
        <div class="col-xs-12 col-sm-3">
            <img src="/img/Increase sales.png"/>
            <h4>New Customers</h4>
            <p>Allow new customers to find and learn more about you</p>
        </div>
        <div class="col-xs-12 col-sm-3">
            <img src="/img/Customer icon 2.png"/>
            <h4>No Hardware</h4>
            <p>Set up and start receiving orders with just a smartphone, tablet or PC</p>
        </div>
        <div class="col-xs-12 col-sm-3 ">
            <img src="/img/mobile review.png"/>
            <h4>Supporting Independent</h4>
            <p>Independents do it better and we support that wholeheartedly. We are exclusive to independents and local chains</p>
        </div>
    </div>
</div>
<div class="container-fluid" id="apply-whatwedo">
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 text-center">
          <img style="width: 100%; padding: 10px 0px; max-width: 800px;" src="/img/welcome/fees.png" title="Fee's" alt="fee"/>
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
      <div class="col-xs-4 hidden-md">
        <h4 class="text-center">Drag pin to your location!</h4>
      </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-lg-8">
            @include('shared/_form_errors')
            <form class="form-horizontal" method="post" action="{{ route('coffee-shop.applied') }}">
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

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <input type="submit" class="btn btn-primary" value="Register your coffee shop">
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4 col-xs-12">
            <div class="hidden-lg visible-md text-center">
              <h4>Drag pin to your location!</h4>
            </div>
            <div id="maps-container" class="draggable-marker" @if(isset($position)) data-position="{{$position}}" @endif></div>
            <p class="help-block">You can drag the pin to be more accurate.</p>
        </div>
    </div>
</div>
@endsection

@section('vendor_scripts')
    <script type="text/javascript" src="//www.google.com/recaptcha/api.js"></script>
    <script>
      $('#content').css('background','#ebebeb')
    </script> 
@endsection
