<div class="row">
    <h2 class="col-xs-12 text-center dark">The best coffee shops near you</h2>
</div>

<div class="row">
    @foreach($featuredShops as $i => $shop)
        @if($i === 0 || $i === 6)
            @include('coffee_shop._large', ['coffeeShop' => $shop])
        @else
            @include('coffee_shop._small', ['coffeeShop' => $shop, 'showXs' => $i === 1])
        @endif
    @endforeach
</div>
