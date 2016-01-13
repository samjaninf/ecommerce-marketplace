@extends('app')

@section('page-title')
    List of orders
@stop

@section('content')
    {{ current_user()->isOwner() }}
    <div class="{{ current_user()->isOwner() ? 'container-fluid' : 'container main-content-padded' }}">
        @if(current_user()->isOwner() )
          
        @else
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
        @endif

        <div class="row">
            <div class="col-sm-3">
                @include('dashboard._menu')
            </div>

            <div class="col-sm-9">
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
