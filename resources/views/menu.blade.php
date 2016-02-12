<nav class="navbar" @if (Route::getCurrentRoute()->getName() != 'welcome') style="background: #fff;" @endif>
    <div class="container-fluid">
        <div class="navbar-header @if (isset($home)) home-bg-overlay @endif">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#main-menu">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a style="padding: 5px 10px;" class="navbar-brand" href="/">
                @if (Route::getCurrentRoute()->getName() === 'welcome')
                    <img src="/img/shared/logo-white.png" alt="Koolbeans">
                @else
                    <img style="height: 45px; top: -10px;" src="/img/pages-logo.png" alt="Koolbeans">
                @endif
            </a>
        </div>

        <div class="collapse navbar-collapse @if (isset($home)) home-bg-overlay @endif" id="main-menu">
            @if(Route::getCurrentRoute() && Route::getCurrentRoute()->getAction() && strpos(Route::getCurrentRoute()->getAction()['controller'], 'WelcomeController@index') === false)
            <form class="col-xs-12 col-sm-5 form-inline" action="{{ route('search') }}" method="post" id="search-form">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <input id="query" type="text" name="query" class="form-control" placeholder="Search...">
                        <input type="hidden" name="location" id="my-current-location">
                        <input type="submit" class="form-control" value="Search">
                        @if(str_contains(URL::previous(), '/search'))
                            <a href="{{ URL::previous() }}" class="btn btn-primary" style="display: inline; color: white">Go back</a>
                        @endif
                    </li>
                </ul>
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
            </form>
            @endif
            @if (Route::getCurrentRoute()->getName() === 'welcome')
                <ul class="nav navbar-nav navbar-right" style="margin: 30px 0px;">
            @else
                <ul class="nav navbar-nav navbar-right">
            @endif

                @if(Auth::check())
                    @if ( current_user()->coffee_shop != null )
                        <li><a href="{{ route('home') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('home') }}">Profile</a></li>
                    @endif
                @elseif(Auth::check() && current_user()->role === 'admin')
                    <li><a href="{{ route('admin.home') }}">Admin dashboard</a></li>
                @else
                    <li><a href="{{ route('coffee-shop.apply') }}">List Your Shop</a></li>
                @endif
                <li><a href="{{ url('/about') }}">How it works</a></li>
                @if (Auth::guest())
                    <li class="sign-up"><a href="{{ url('/auth/register') }}">Register</a></li>
                    <li class="sign-in dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">Log In</a>
                        <div class="dropdown-menu" role="menu" style="padding: 15px">
                            <form role="form" method="POST" action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label for="email">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Login</button>

                                    <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
                                </div>
                            </form>

                            <hr>

                            <b>Not registered with us?</b>
                            <a href="{{ url('auth/register') }}" class="btn btn-primary" style="color: white">Register for free</a>
                        </div>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">{{ current_user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" style="position: relative">
                            @if(current_user()->role === 'admin')
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
