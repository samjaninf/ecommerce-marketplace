<table class="table">
    <thead>
    <tr>
        <th>Referenced product</th>
        <th>Linked products</th>
        <th>Offer type</th>
        <th>Reductions</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($offers as $offer)
        <tr>
            <td>{{ $coffeeShop->getNameFor($product) }}</td>
            <td>
                @foreach($offers->details as $detail)
                    {{ $coffeeShop->getNameFor($detail->product) }}
                @endforeach
            </td>
            <td>
                @foreach($offers->details as $detail)
                    {{ $detail->getTypeDisplay() }}
                @endforeach
            </td>
            <td>
                @foreach($offers->details as $detail)
                    {{ $coffeeShop->getSizeDisplayName('xs') }}: {{ $detail->amount_xs }} -
                    {{ $coffeeShop->getSizeDisplayName('sm') }}: {{ $detail->amount_sm }} -
                    {{ $coffeeShop->getSizeDisplayName('md') }}: {{ $detail->amount_md }} -
                    {{ $coffeeShop->getSizeDisplayName('lg') }}: {{ $detail->amount_lg }}
                @endforeach
            </td>
        </tr>
    @endforeach
    <tr>
        <td class="success" colspan="5">
            <a href="{{ route('offers.create', [ 'coffeeShop' => $coffeeShop ]) }}">
                Add an offer
            </a>
        </td>
    </tr>
    </tbody>
</table>
