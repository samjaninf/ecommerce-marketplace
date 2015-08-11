@extends('app')

@section('page-title')
    Sorry, page not found
@stop

@section('content')
    <div class="container main-content-padded" style="min-height: 60%">

        <div class="row">
            <div class="col-xs-12">
                <h1>@yield('page-title')</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <p>
                    You've encountered a problem or reached a page that does not exist.<br>
                    <br>

                    <a href="{{ URL::previous() }}" class="btn btn-primary">Go Back</a>
                </p>
            </div>
        </div>

    </div>
@stop
