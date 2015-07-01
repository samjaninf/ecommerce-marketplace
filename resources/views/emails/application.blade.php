@extends('emails._main')

@section('mail')
    Thank you for registering to <a href="{{ url('/') }}">Koolbeans</a>!<br><br>

    Your coffee shop has been acccepted by our administrator!

    You can now <a href="{{ url('/my-shop') }}">customize your coffee shop</a> as you want!
@stop
