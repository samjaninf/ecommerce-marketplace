@extends('app')

@section('page-title')
    Your coffee shop
@endsection

@section('content')
    <div class="container-fluid">
        @include('dashboard._header')
        <div class="row">
            <div class="col-sm-3">
                @include('dashboard._menu')
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-xs-12">
                        <h4><a class="btn btn-primary android" href="/app.apk?r={{ time() }}">Download the android application</a></h4>
                    </div>
                </div>
                @if ( $coffeeShop->views > 10)    
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>You had {{ $coffeeShop->views }} visitors in total!</h4>
                        </div>
                        <div class="col-xs-12">
                            <h4>Your total sales for {{ $sales[0]->actual_date }} is £{{ number_format($sales [0]->price /100, 2, '.', ',') }}</h4>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>Thanks for joining KoolBeans!</h2>
                        </div>
                    </div>
                @endif
                @if ($coffeeShop->stripe_user_id)
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>Current orders</h2>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Order</th>
                                    <th>Name</th>
                                    <th>Collection time</th>
                                    <th>Order status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <td>
                                            @foreach($order->order_lines as $line)
                                                @if($line->product->type == 'drink')
                                                    {{ $coffeeShop->getSizeDisplayName($line->size) }}
                                                @endif
                                                {{ $coffeeShop->getNameFor($line->product) }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $order->user->name }}
                                        </td>
                                        <td>
                                            {{ $order->pickup_time }}
                                        </td>
                                        <td>
                                            {{ $order->status }}
                                            <a href="{{ route('next-order-status', [ $order ]) }}"
                                               class="btn btn-success btn-xs pull-right">
                                                Set as {{ $order->getNextStatus() }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-12">
                            <h2>Most bought products</h2>
                            <ul class="list-group">
                                @foreach($mostBought as $product)
                                    <li class="list-group-item">
                                        {{$coffeeShop->getNameFor($coffeeShop->findProduct($product->product_id))}}:
                                        {{$product->aggregate}} times
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="col-xs-12">
                        <h2 class="bg-danger text-warning" style="padding: 15px; font-size: 20px;">Hi {{ current_user()->name }}, <a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_7hpA87d09JFpXVNWgswHbG4ZnzhMyZ2L&scope=read_write">Connect to stripe</a>. You will unable to process online orders without Stripe!</h2>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
