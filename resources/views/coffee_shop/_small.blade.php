<div class="col-sm-4 hidden-xs">
    <div class="featured-coffee-shop">
        @if($coffeeShop !== null)
            {{$coffeeShop->name}}: {{$coffeeShop->featured}}
        @endif
    </div>
</div>
