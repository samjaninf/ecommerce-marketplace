<div class="col-sm-8">
    @if($coffeeShop !== null)
        <div class="featured-coffee-shop" style="background-image: url({{$coffeeShop->mainImage() }})">
            <div class="info text-center">
                <h5 class="text-center" style="padding-top: 20px">
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
                    <a href="{{ route('coffee-shop.show', ['coffeeShop' => $coffeeShop]) }}"
                       class="btn btn-success">Order <span class="hidden-xs"> a Coffee </span></a>
                </div>
            </div>
        </div>
    @else
        <div class="featured-coffee-shop">
            #
        </div>
    @endif
</div>
