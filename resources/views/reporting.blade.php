@extends('app')

@section('page-title')
    Reporting
@stop

@section('content')
    <div class="container main-content-padded">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    @yield('page-title')
                    <span class="page-actions">
                        <a href="{{ URL::previous() }}" class="btn btn-success">Go back</a>
                    </span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                @include('dashboard._menu')
            </div>

            <div class="col-sm-9">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($reporting as $report)
                        <tr>
                            <td>{{ $report->actual_date }}</td>
                            <td>£ {{ number_format($report->price / 100., 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
