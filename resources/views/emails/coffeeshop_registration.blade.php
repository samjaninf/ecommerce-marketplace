@extends('emails._main')

@section('mail')
    Thank you for registering to <a href="{{ url('/') }}">Koolbeans</a>!

    Your coffee shop is waiting for you now. <a href="{{ route('my-shop') }}">Click here</a> to access it!
@stop
