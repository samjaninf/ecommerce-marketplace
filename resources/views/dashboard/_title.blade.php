<h1>
    <span class="font-inherit">
        {{$coffeeShop->name}}
    </span>
    <span class="hide visible-lg-inline">
        @yield('page-title')
    </span>
    <span id="page-actions">
        <a href="{{ route('coffee-shop.show', ['coffeeshop' => $coffeeShop]) }}"
           class="btn btn-primary">
            Review your shop
        </a>
    </span>
</h1>
