<div class="col-sm-4 @if( ! $showXs) hidden-xs @endif">
    <div class="featured-coffee-shop">
        @if($coffeeShop !== null)
            {{$coffeeShop->name}}: {{$coffeeShop->featured}}
        @endif
    </div>
</div>
