<div class="offer bg-{{$bgNum}}">
    <div class="border">
        @if($offer->exists)
            <h4><a href="{{ route('apply-offer', [ 'offer' => $offer ]) }}">{{ $offer->getName() }}</a></h4>
            <b>{{ $offer->coffee_shop->getNameFor($offer->productOnDeal()) }}</b><br>
            <i>When buying a {{ $offer->coffee_shop->getNameFor($offer->product) }}</i>
        @else
            <h4>No offer</h4>
        @endif
    </div>
</div>
