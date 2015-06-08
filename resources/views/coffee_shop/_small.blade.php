<div class="col-sm-4 @if( ! $showXs) hidden-xs @endif">
    @if($coffeeShop !== null)
        <div class="featured-coffee-shop" style="background-image: url({{$coffeeShop->mainImage() }})">
            <div class="info small-featured text-center">
                <h5 class="text-center">
                    {{ $coffeeShop->name }}
                </h5>
                <p>
                    <i>{{ $coffeeShop->location }}</i>
                </p>
                @include('coffee_shop._rating', ['rating' => $coffeeShop->getRating()])
                <div class="review hidden-sm hidden-xs">
                    {{ $coffeeShop->getBestReview() ? $coffeeShop->getBestReview()->pivot->review : null}}
                </div>
                <div class="actions">
                    <a href="{{ route('coffee-shop.order.create', ['coffeeShop' => $coffeeShop]) }}"
                       class="btn btn-success">Order <span class="hidden-xs"> a Coffee </span></a>
                    <a href="{{ route('coffee-shop.show', ['coffeeShop' => $coffeeShop]) }}"
                       class="btn btn-primary">View <span class="hidden-xs">Profile</span></a>
                </div>
            </div>
        </div>
    @else
        <div class="featured-coffee-shop">
            #
        </div>
    @endif
</div>
