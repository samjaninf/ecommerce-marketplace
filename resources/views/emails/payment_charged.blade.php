@extends('emails._main')

@section('mail')
    We just charged you of £ {{ $amount }}.
    @if($refund > 0)
        You have been refunded of £ {{ $refund }} from the £ {{ $initial }} initially authorized.
    @endif
@stop
