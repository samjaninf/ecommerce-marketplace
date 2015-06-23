@extends('app')

@section('content')
    <div class="container main-content-padded">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    Set your opening times
                    <span id="page-actions">
                        <a href="{{ route('my-shop') }}" class="btn btn-primary">Your shop</a>
                    </span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-3">
                        <h4>Opening times</h4>
                    </div>

                    <div class="col-sm-4">
                        <h4>Closing times</h4>
                    </div>
                </div>
                <form action="{{ route('coffee-shop.opening-times', ['coffee_shop' => $coffeeShop]) }}" method="post">
                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        <div class='row'>
                            <div class='col-sm-3'>
                                <div class='checkbox'>
                                    <label id="{{$day}}">
                                        <input type="checkbox"
                                               id="{{$day}}"
                                               name="{{$day}}"
                                               @if($coffeeShop->isOpenOn($day)) checked @endif>
                                        {{ ucfirst($day) }}
                                    </label>
                                </div>
                            </div>
                            <div class='col-sm-4'>
                                <div class='form-group'>
                                    <label for="start_time_{{$day}}">
                                        <input type="text"
                                               id="start_time_{{$day}}"
                                               class="form-control"
                                               name="start_time_{{$day}}"
                                               value="{{ $coffeeShop->getStartingHour($day) }}">
                                    </label>
                                </div>
                            </div>
                            <div class='col-sm-4'>
                                <div class='form-group'>
                                    <label for="end_time_{{$day}}">
                                        <input type="text"
                                               id="end_time_{{$day}}"
                                               class="form-control"
                                               name="stop_time_{{$day}}"
                                               value="{{ $coffeeShop->getStoppingHour($day) }}">
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-3">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                            <input type="submit" class="btn btn-primary" value="Change opening times">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
