<div class="offer bg-{{$bgNum}}">
    <div class="border">
        @if($offer->exists)
            <a href="{{ route('apply-offer', [ 'offer' => $offer ]) }}">
                <h4>{{ $offer->getName() }}</h4>
                <b>{{ $offer->coffee_shop->getNameFor($offer->productOnDeal()) }}</b><br>
                <i>When buying a {{ $offer->coffee_shop->getNameFor($offer->product) }}</i>
            </a>
        @else
            <h4>No offer</h4>
        @endif
    </div>
</div>
