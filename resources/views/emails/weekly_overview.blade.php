@extends('emails._main')

@section('mail')
    This week, you have spent {{$total}} on our website.<br><br>

    @if(count($coffeeShops) > 0)
        Please review these coffee shops:<br>
        @foreach($coffeeShops as $coffeeShop)
            <a href="{{ route('coffee-shop.show', ['coffee_shop' => $coffeeShop->id]) }}">
                Click here to review {{$coffeeShop->name}}
            </a><br>
        @endforeach
    @endif

    <br>Thank you!
@stop
