<div class="offer bg-{{$bgNum}}">
    <div class="border">
        @if($offer->exists)
            <a href="{{ route('coffee-shop.show', $offer->id) }}">
                <h4>{{ $offer->name }}</h4>
                <b>Buy 1 get 1 half price!</b><br>
                @if($offer->offer_drink_only)
                    <i>On Drinks Only</i>
                @endif
            </a>
        @else
            <h4>No offer</h4>
        @endif
    </div>
</div>
