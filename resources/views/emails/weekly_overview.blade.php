@extends('emails._main')

@section('mail')
    This week, you have spent {{$total}} on our website.

    @if(count($coffeeShops) > 0)
        Please review these coffee shops:
        @foreach($coffeeShops as $coffeeShop)
            <a href="{{ route('coffee-shop.show', ['coffee_shop' => $coffeeShop->id]) }}">Click here to do so</a>
        @endforeach
    @endif

    Thank you for doing business with us!
@stop
