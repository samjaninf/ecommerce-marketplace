<h1>
    <span class="font-inherit">
        {{$coffeeShop->name}}
    </span>
    <span class="hide visible-lg-inline">
        @yield('page-title')
    </span>
    <span id="page-actions">
        @if(strpos(Route::getCurrentRoute()->getAction()['controller'], 'HomeController@index') === false)
            <a href="{{ route('my-shop') }}" class="btn btn-primary">Dashboard</a>
        @else
            <a href="{{ route('coffee-shop.show', ['coffeeshop' => $coffeeShop]) }}"
               class="btn btn-primary">
                Review your shop
            </a>
            <a href="{{ route('coffee-shop.products.index', ['coffeeshop' => $coffeeShop]) }}"
               class="btn btn-success">
                Your menu
            </a>
        @endif
    </span>
</h1>
