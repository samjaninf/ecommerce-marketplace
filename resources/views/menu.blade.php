<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#main-menu">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="/img/shared/logo.png" alt="Koolbeans">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="main-menu">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('home') }}">Dashboard</a></li>
                @if( ! Auth::guest() && current_user()->role === 'admin')
                    <li><a href="{{ route('admin.home') }}">Admin dashboard</a></li>
                @elseif( ! Auth::guest() && ! current_user()->hasValidCoffeeShop())
                    <li><a href="{{ route('coffee-shop.apply') }}">List Your Shop</a></li>
                @endif
                <li><a href="{{ url('/about') }}">About</a></li>
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
