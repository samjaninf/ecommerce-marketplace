<div class="col-sm-8">
    <div class="featured-coffee-shop">
        @if($coffeeShop !== null)
            {{$coffeeShop->name}}: {{$coffeeShop->featured}}
        @endif
    </div>
</div>
