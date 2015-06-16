@extends('app')

@section('page-title')
    Order correctly sent!
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>@yield('page-title')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-hover">
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

                <p class="offers">
                    Current offer applying:<br>
                    {{ Session::has('offer-used') ? display_offer(Session::get('offer-used')) : "" }}
                </p>

                <h4>Pickup time: {{$order->pickup_time}}</h4>
            </div>
        </div>
    </div>
@stop
