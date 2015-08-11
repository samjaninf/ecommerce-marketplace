@extends('app')

@section('page-title')
    Order successfully placed!
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>@yield('page-title')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @if(Session::has('newauth') && session('newauth') == 'yes')
                    <p>
                        An authorization of £ 15 has been made to your bank.
                        However, we will not charge you for that amount.
                        You wont be charged until you spend more than £ 15 in total in our shops.
                        In 6 days, you will automatically be charged for the amount accumulated over the week.
                    </p>
                @endif
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Your order</th>
                        <th>Total: £ {{$order->price / 100.}}</th>
                    </tr>
                    </thead>
                    @foreach($order->order_lines as $line)
                        <tr>
                            <td>
                                {{$line->product->type == 'drink' ? $coffeeShop->getSizeDisplayName($line->size) : ''}}
                                {{$coffeeShop->getNameFor($line->product)}}
                            </td>
                            <td>£ {{$line->price / 100.}}</td>
                        </tr>
                    @endforeach
                </table>

                <p class="offers">
                    Current offer applying:<br>
                    {{ Session::has('offer-used') ? display_offer(Session::get('offer-used')) : "" }}
                </p>

                <h4>Pickup time: {{$order->pickup_time}}</h4>

                <p>Tweet about this order and you will get 5 KB points! How cool is that?</p>
                <a href="https://twitter.com/share" data-size="large" class="twitter-share-button" data-count="none" data-url="https://koolbeans.co.uk/" data-text="Just ordered a coffee from {{ $order->coffee_shop->name }} using @KoolBeansUK!">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        (function () {
            function handleTweetEvent(event){
                if (event) {
                    $.ajax('{{ route('order.tweet', $order->id) }}');
                    $('.twitter-share-button').hide();
                }
            }
            twttr.events.bind('tweet', handleTweetEvent);
        })()
    </script>
@stop
