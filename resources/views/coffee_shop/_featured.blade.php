<div class="row">
    <h2 class="col-xs-12 text-center dark">Our Coffee Shops</h2>
</div>

<div class="row">
    @foreach($featuredShops as $i => $shop)
        @if($i === 0 || $i === 6)
            @include('coffee_shop._large', ['coffeeShop' => $shop])
        @else
            @if($i === 2 || $i === 5)
                <div class="row">
                    @endif

                    @include('coffee_shop._small', ['coffeeShop' => $shop])

                    @if($i === 1 || $i === 4)
                </div>
            @endif
        @endif
    @endforeach
</div>
