<h1>
    <span class="font-inherit">
        {{$coffeeShop->name}}
    </span>
    <span class="hide visible-lg-inline">
        @yield('page-title')
    </span>
        <a href="{{ route('coffee-shop.show', ['coffeeshop' => $coffeeShop]) }}"
           class="btn btn-primary pull-right">
            Review your shop
        </a>
</h1>