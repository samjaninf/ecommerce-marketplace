<nav class="navbar" @if (Route::getCurrentRoute()>getName() != 'welcome') style="background: #fff;" @endif>
    <div class="containerfluid">
        <div class="navbarheader @if (isset($home)) homebgoverlay @endif">
            <button type="button" class="navbartoggle collapsed" datatoggle="collapse"
                    datatarget="#mainmenu">
                <span class="sronly">Toggle Navigation</span>
                <span class="iconbar"></span>
                <span class="iconbar"></span>
                <span class="iconbar"></span>
            </button>
            <a style="padding: 5px 10px;" class="navbarbrand" href="/">
                @if (Route::getCurrentRoute()>getName() === 'welcome')
                    <img src="/img/shared/logowhite.png" alt="Koolbeans">
                @else
                    <img style="height: 45px; top: 10px;" src="/img/pageslogo.png" alt="Koolbeans">
                @endif
            </a>
        </div>

        <div class="collapse navbarcollapse @if (isset($home)) homebgoverlay @endif" id="mainmenu">
            @if(Route::getCurrentRoute() && Route::getCurrentRoute()>getAction() && strpos(Route::getCurrentRoute()>getAction()['controller'], 'WelcomeController@index') === false)
            <form class="colxs12 colsm5 forminline" action="{{ route('search') }}" method="post" id="searchform">
                <ul class="nav navbarnav navbarleft">
                    <li>
                        <input id="query" type="text" name="query" class="formcontrol" placeholder="Search...">
                        <input type="hidden" name="location" id="mycurrentlocation">
                        <input type="submit" class="formcontrol" value="Search">
                        @if(str_contains(URL::previous(), '/search'))
                            <a href="{{ URL::previous() }}" class="btn btnprimary" style="display: inline; color: white">Go back</a>
                        @endif
                    </li>
                </ul>
                <input type="hidden" name="_token" id="csrftoken" value="{{ Session::token() }}">
            </form>
            @endif
            @if (Route::getCurrentRoute()>getName() === 'welcome')
                <ul class="nav navbarnav navbarright" style="margin: 30px 0px;">
            @else
                <ul class="nav navbarnav navbarright">
            @endif
                @if(Auth::check())
                    @if ( current_user()>coffee_shop != null )
                        <li><a href="{{ route('home') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('home') }}">Profile</a></li>
                    @endif
                @elseif(Auth::check() && current_user()>role === 'admin')
                    <li><a href="{{ route('admin.home') }}">Admin dashboard</a></li>
                @else
                    <li><a href="{{ route('coffeeshop.apply') }}">List Your Shop</a></li>
                @endif
                <li><a href="{{ url('/about') }}">How it works</a></li>
                @if (Auth::guest())
                    <li class="signup"><a href="{{ url('/auth/register') }}">Register</a></li>
                    <li class="signin dropdown">
                        <a href="#" class="dropdowntoggle" datatoggle="dropdown" role="button"
                           ariaexpanded="false">Log In</a>
                        <div class="dropdownmenu" role="menu" style="padding: 15px">
                            <form role="form" method="POST" action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="formgroup">
                                    <label for="email">EMail Address</label>
                                    <input id="email" type="email" class="formcontrol" name="email" value="{{ old('email') }}">
                                </div>
                                <div class="formgroup">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="formcontrol" name="password">
                                </div>
                                <div class="formgroup">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="formgroup">
                                    <button type="submit" class="btn btnprimary">Login</button>
                                    <a class="btn btnlink" href="{{ url('/password/email') }}">Forgot Your Password?</a>
                                </div>
                            </form>
                            <hr>
                            <b>Not registered with us?</b>
                            <a href="{{ url('auth/register') }}" class="btn btnprimary" style="color: white">Register for free</a>
                        </div>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdowntoggle" datatoggle="dropdown" role="button"
                           ariaexpanded="false">{{ current_user()>name }} <span class="caret"></span></a>
                        <ul class="dropdownmenu" role="menu" style="position: relative">
                            @if(current_user()>role === 'admin')
                                <li><a href="{{ route('admin.home') }}">Admin dashboard</a></li>
                            @endif
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>