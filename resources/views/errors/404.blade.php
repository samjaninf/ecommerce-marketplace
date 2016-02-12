@extends('app')

@section('page-title')
    Sorry, page not found
@stop

@section('content')
    <div class="container main-content-padded" style="min-height: 60%">

        <div class="row">
            <div class="col-xs-12">
                <h1>Opps, an error occured.</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <p>
                    Opps, an error occured. We've been notified and will take a look. In the meantime why not search for a coffee shop?<br>
                    <br>

                    <a href="{{ URL::previous() }}" class="btn btn-primary">Go Back</a>
                </p>
            </div>
        </div>

    </div>
@stop
