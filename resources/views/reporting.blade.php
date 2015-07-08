@extends('app')

@section('page-title')
    Reporting
@stop

@section('content')
    <div class="container-fluid">
        @include('dashboard._header')
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
