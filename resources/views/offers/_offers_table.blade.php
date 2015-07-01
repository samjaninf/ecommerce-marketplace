<table class="table">
    <thead>
    <tr>
        <th>Product</th>
        <th>Linked products</th>
        <th>Offer type</th>
        <th>Reductions</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($offers as $offer)
        <tr>
            <td>{{ $coffeeShop->getNameFor($offer->product) }}</td>
            <td>
                @foreach($offer->details as $detail)
                    {{ $coffeeShop->getNameFor($detail->product) }}<br>
                @endforeach
            </td>
            <td>
                @foreach($offer->details as $detail)
                    {{ $detail->getTypeDisplay() }}<br>
                @endforeach
            </td>
            <td>
                @foreach($offer->details as $detail)
                    @if ($detail->type == 'free')
                        100%<br>
                    @else
                        @if($detail->amount_xs) {{ $coffeeShop->getSizeDisplayName('xs') }}
                        : {{ $detail->amount('xs') }} @endif
                        @if($detail->amount_sm) {{ $coffeeShop->getSizeDisplayName('sm') }}
                        : {{ $detail->amount('sm') }} @endif
                        @if($detail->amount_md) {{ $coffeeShop->getSizeDisplayName('md') }}
                        : {{ $detail->amount('md') }} @endif
                        @if($detail->amount_lg) {{ $coffeeShop->getSizeDisplayName('lg') }}
                        : {{ $detail->amount('lg') }} @endif
                    @endif
                    <br>
                @endforeach
            </td>
            <td>
                @if($offer->activated)
                    <a href="{{ route('offers.toggle-activation', ['offer' => $offer]) }}"
                       class="btn btn-warning btn-xs">Deactivate</a>
                @else
                    <a href="{{ route('offers.toggle-activation', ['offer' => $offer]) }}"
                       class="btn btn-success btn-xs">Activate</a>
                @endif
                <a href="{{ route('offers.destroy', ['offer' => $offer]) }}"
                   class="btn btn-danger btn-xs"
                   data-confirm="Are you sure you want to delete this offer?"
                   data-method="delete">Delete</a>
            </td>
        </tr>
    @endforeach
    <tr>
        <td class="success" colspan="5">
            <a href="{{ route('offers.create') }}">
                Add an offer
            </a>
        </td>
    </tr>
    </tbody>
</table>
