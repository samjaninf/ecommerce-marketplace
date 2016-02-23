<div class="container-fluid" id="footer">
    <h2>Find your coffee now...</h2>

    <form class="form-inline" action="{{route('search')}}" method="post" id="search-form">
        <div class="form-group @if($errors->any()) {{$errors->has('query') ? 'has-error' : 'has-success'}} @endif">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>
            <label for="query" class="sr-only">Query:</label>

            <div class="input-group">
                <input id="footerquery"
                       name="query"
                       type="text"
                       placeholder="Enter your location to find a shop..."
                       class="form-control input-lg"
                       value="{{old('query')}}">

                <input class="btn btn-primary btn-lg" type="submit" value="Search">
            </div>
        </div>
    </form>
</div>
<div id="bottom-footer" class="container-fluid">
    <img src="/img/shared/grey-logo.png" style="max-width: 100%;" alt="Koolbeans">
    <ul class="my-nav">
        <li><a href="{{ route('home') }}">Home</a></li>
        @if( ! Auth::guest() && current_user()->role === 'admin')
            <li><a href="{{ route('admin.home') }}">Admin dashboard</a></li>
        @elseif( ! Auth::guest() && current_user()->hasValidCoffeeShop())
            <li><a href="{{ route('my-shop') }}">Your shop</a></li>
        @else
            <li><a href="{{ route('coffee-shop.apply') }}">List Your Shop</a></li>
        @endif
        <li><a href="{{ url('/about') }}">About</a></li>
        @if (Auth::guest())
            <li><a href="{{ url('/auth/register') }}">Register</a></li>
            <li><a href="{{ url('/auth/login') }}">Log In</a></li>
        @else
            <li>
                <a href="{{ url('/auth/logout') }}">Logout</a>
            </li>
        @endif
    </ul>

    <div class="text-center" id="terms-and-conditions">
        <a href="{{ url('/terms') }}">Terms and Conditions</a> | <a href="{{ url('/terms-of-use') }}">Terms of Use</a>
    </div>

    <div class="social">
        <a href="https://www.facebook.com/KoolBeansUK" target="_blank"><i class="fa fa-facebook circle"></i></a>
        <a href="https://www.instagram.com/koolbeansuk/" target="_blank"><i class="fa fa-instagram circle" target="_blank"></i></a>
        <a href="https://twitter.com/koolbeansuk" target="_blank"><i class="fa fa-twitter circle"></i></a>
    </div>

    <div class="copyright">
        &copy; 2015 Koolbeans. All rights reserved.<br>
        Website by <a href="#">The Workroom</a>.
    </div>
</div>
<div id="request-callback" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Hi, thanks for contacting us. <br />Fill in the info below and we will get back to you asap!</h4>
      </div>
      <div class="modal-body">
            <form class="coffee-signup form-horizontal" method="post" action="/requestcallback">
                <div class="form-group @if($errors->any()) {{$errors->has('username') ? 'has-error' : 'has-success'}} @endif">
                    <label for="rname" class="col-sm-12"><span class="col-accent">1.</span> Your name:</label>

                    <div class="col-sm-12">
                        <input id="rname"
                               name="rname"
                               type="text"
                               placeholder="John Smith"
                               class="form-control"
                               value="{{old('name')}}">
                    </div>
                </div>
                <div class="form-group @if($errors->any()) {{$errors->has('username') ? 'has-error' : 'has-success'}} @endif">
                    <label for="rcname" class="col-sm-12"><span class="col-accent">2.</span> Coffee Shop Name:</label>

                    <div class="col-sm-12">
                        <input id="rcname"
                               name="rcname"
                               type="text"
                               placeholder="Coffee shop name"
                               class="form-control"
                               value="{{old('name')}}">
                    </div>
                </div>
                <div class="form-group @if($errors->any()) {{$errors->has('username') ? 'has-error' : 'has-success'}} @endif">
                    <label for="rphone" class="col-sm-12"><span class="col-accent">3.</span> Phone Number:</label>

                    <div class="col-sm-12">
                        <input id="rphone"
                               name="rphone"
                               type="text"
                               placeholder="Phone number"
                               class="form-control"
                               value="{{old('name')}}">
                    </div>
                </div>
                <div class="form-group @if($errors->any()) {{$errors->has('username') ? 'has-error' : 'has-success'}} @endif">
                    <label for="remail" class="col-sm-12"><span class="col-accent">4.</span> Email:</label>

                    <div class="col-sm-12">
                        <input id="remail"
                               name="remail"
                               type="text"
                               placeholder="hello@example.com"
                               class="form-control"
                               value="{{old('name')}}">
                    </div>
                </div>
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-primary" value="Request A Callback">
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>