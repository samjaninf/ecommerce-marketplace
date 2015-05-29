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
                    <li class="sign-up"><a href="{{ url('/auth/register') }}">Register</a></li>
                    <li class="sign-in"><a href="{{ url('/auth/login') }}">Log In</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">{{ current_user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
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
