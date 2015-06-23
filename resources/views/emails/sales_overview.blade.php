@extends('emails._main')

@section('mail')
    Here is an overview of your best sales.

    <table>
        <thead>
        <tr>
            <th>Orders</th>
            <th>Total: £ {{$total}}</th>
        </tr>
        </thead>
        @foreach($mostBought as $product)
            <tr>
                <td>
                    {{ $coffeeShop->getNameFor($product) }}
                    {{$coffeeShop->getNameFor($coffeeShop->findProduct($product->product_id))}}:
                    {{$product->aggregate}} times
                </td>
            </tr>
        @endforeach
    </table>

    Thank you for doing business with us!
@stop
