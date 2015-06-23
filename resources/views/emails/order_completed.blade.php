@extends('emails._main')

@section('mail')
    Thank you for your order!<br>

    Here is your receipt:<br><br>

    <table>
        <thead>
        <tr>
            <th>Your order</th>
            <th>Total: £ {{$order->price / 100.}}</th>
        </tr>
        </thead>
        @foreach($order->order_lines as $line)
            <tr>
                <td>
                    {{$line->product->type == 'drink' ? $coffeeShop->getSizeDisplayName($line->size) : ''}}
                    {{$coffeeShop->getNameFor($line->product)}}
                </td>
                <td>£ {{$line->price / 100.}}</td>
            </tr>
        @endforeach
    </table>
@stop
