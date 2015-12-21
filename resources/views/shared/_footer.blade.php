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
    <img src="/img/shared/grey-logo.png" alt="Koolbeans">
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
        <a href="#"><i class="fa fa-facebook circle"></i></a>
        <a href="#"><i class="fa fa-instagram circle"></i></a>
        <a href="#"><i class="fa fa-twitter circle"></i></a>
    </div>

    <div class="copyright">
        &copy; 2015 Koolbeans. All rights reserved.<br>
        Website by <a href="#">The Workroom</a>.
    </div>
</div>
