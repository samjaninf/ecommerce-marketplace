@extends('app')

@section('page-title')
    List of orders
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
            <div class="col-xs-12">
                <table class="table table-hovered">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->created_at }}</td>
                            <td>£ {{ number_format($order->price / 100., 2) }}</td>
                            <td>
                                <a href="{{ route('order.success', ['order' => $order]) }}"
                                   class="btn btn-primary btn-xs">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@stop
