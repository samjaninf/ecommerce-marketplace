@extends('app')

@section('page-title')
    Summary
@stop

@section('content')
<div id="order-top" style="background-image: url('{{ $coffeeShop->mainImage() }}')">
    <div class="order-top-overlay">
    </div>
    <div class="container">
        <div class="row">
            <h1 class="shop_name"> {{$coffeeShop->name}}
            <h3> <span class="glyphicon glyphicon-map-marker"> </span> {{$coffeeShop->location}} </h3>
            <span class="ratings">
                @include('coffee_shop._rating', ['rating' => $coffeeShop->getRating()])
            </span>

            <div class="order_header col-xs-12 col-sm-8 col-md-8 col-lg-6 col-sm-offset-2 col-md-offset-2 col-lg-offset-3">
                <h2>Order Summary</h2>
            </div>
        </div>
    </div>
</div>
<div id="order">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 col-sm-offset-2 col-md-offset-2 col-lg-offset-3 order-page" id="order-inner">

                    <div id="error-message" style="display: none">
                        <div style="padding: 5px;">
                            <div id="inner-message" class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                
                            </div>
                        </div>
                    </div>
                    <?php $total = 0; ?>
                    @foreach ( $order->order_lines as $line)
                        <div class="row order-lines">
                            <div class="col-xs-8">
                                {{$line->product->type == 'drink' ? $coffeeShop->getSizeDisplayName($line->size) : ''}}
                                {{$coffeeShop->getNameFor($line->product)}}
                            </div>
                            <div class="col-xs-4 text-right">
                                <?php $total = $total + $line->price; ?>
                                £{{ number_format((float)$line->price / 100, 2, '.', '') }}
                            </div>
                        </div>
                    @endforeach
                    <div class="row order-total">
                        <div class="col-xs-4">
                            <a class="btn btn-primary" href="{{ URL::previous() }}">
                                Amend <span class="hidden-xs">Order</span>
                            </a>
                        </div>
                        <div class="col-xs-8 text-right">
                            @if ($order->make_on_arriving != 0)
                                <p>Make On Arrival</p>
                            @else 
                                <p>Pickup time: {{ $order->pickup_time }}</p>
                            @endif
                            <h3>Total: £{{ number_format((float)$total / 100, 2, '.', '') }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <p class="offers">
                            @if(Session::has('offer-used'))
                            Current offer applying:<br>
                            {{ display_offer(Session::get('offer-used', $coffeeShop)) }}
                            @endif
                        </p>
                        @if($order->price < 1500 && current_user()->transactions()->orderBy('id', 'desc')->first() !== null && current_user()->transactions()->orderBy('id', 'desc')->first()->charged == true)
                            <p>
                                An authorization of £ 15 will be made to your bank.
                                However, we will not charge you for that amount.
                                You wont be charged until you spend more than £ 15 in total in our shops.
                                In 6 days, you will automatically be charged for the amount accumulated over the week.
                            </p>
                        @endif
                    </div>
                    <div class="row">

                        <div class="col-xs-12">
                            <h3 class="text-center secure-payment"><img src="/img/lock.png" alt="secure"/>Please make your Secure Payment</h3>
                        </div>
                        <div class="col-xs-12 text-center secure-payment-text">
                            <p>Pay online using our secure checkout - with no minimum spends and we'll even store your payment details securely to make your next transaction even easier.</p>
                        </div>
                        <div class="text-center col-xs-12" style="padding: 20px 0px;">
                            <img src="/img/trustwave.png" alt="Trust Wave"/>
                        </div>

                    </div>
                    <div class="row">
                        <form accept-charset="UTF-8"
                              action="{{ route('coffee-shop.order.checkout', ['coffeeShop' => $coffeeShop, 'order' => $order]) }}"
                              class="require-validation @if(current_user()->hasStripeId()) hide @endif"
                              data-cc-on-file="false"
                              id="payment-form"
                              method="post">
                            <div class="form-row">
                                <div class="col-xs-12 form-group required">
                                    
                                    <input class="form-control" size="4" type="text" placeholder="Name On Card" title="Name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-xs-12 form-group card required">
                                    <input data-stripe="number"
                                           placeholder="Card Number"
                                           class="form-control card-number"
                                           size="20"
                                           type="text">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-xs-4 form-group expiration required">
                                    <label class="control-label">Expiry Date:</label>
                                    <input class="form-control card-expiry-month"
                                           data-stripe="exp-month"
                                           placeholder="Month"
                                           size="2"
                                           type="text">
                                </div>
                                <div class="col-xs-4 form-group expiration required">
                                    <label class="control-label"> </label>
                                    <input class="form-control card-expiry-year"
                                           data-stripe="exp-year"
                                           placeholder="Year"
                                           size="4"
                                           type="text">
                                </div>
                                <div class="col-xs-4 form-group cvc required">
                                    <label class="control-label">CVC:</label>
                                    <input data-stripe="cvc"
                                           class="form-control card-cvc"
                                           placeholder="ex. 311"
                                           size="4"
                                           type="text">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-xs-12 form-group payment-outer">
                                    <div class="form-row">
                                        <div class="col-md-12 form-group payment-inner">
                                            <button class="form-control btn btn-success submit-button" type="submit">Make Payment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 error form-group hide">
                                    <div class="alert-danger alert">
                                        Please correct the errors and try again.
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <form method="post"
                                    class="@if(!current_user()->hasStripeId()) hide @endif"
                                    id="existingCardForm"
                                    action="{{ route('coffee-shop.order.checkout', ['coffeeShop' => $coffeeShop, 'order' => $order]) }}"
                                    >
                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                                <button class="btn btn-success col-xs-7" style="margin: 10px;" type="submit">Submit Payment</button>
                                <a href="#" class="btn btn-default col-xs-4 col-xs-offset-1" style="margin: 10px;" id="changeCard">Change <span class="hidden-xs">card</span></a>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('vendor_scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@stop

@section('scripts')
    <script type="text/javascript">
        Stripe.setPublishableKey('pk_test_SFOyFoTWJB3TTq0zUKH1Ajla');

        jQuery(function($) {
            $('#changeCard').click(function (event) {
                event.preventDefault();

                $('#payment-form').removeClass('hide');
                $('#existingCardForm').addClass('hide');

                return false;
            });
            $('#payment-form').submit(function(event) {
                var $form = $(this);

                $form.find('button').prop('disabled', true);

                Stripe.card.createToken($form, stripeResponseHandler);

                return false;
            });

            function stripeResponseHandler(status, response) {
                var $form = $('#payment-form');

                if (response.error) {
                    console.log('hmm');
                    $('#error-message').find('#inner-message').text(response.error.message);
                    $('#error-message').show();
                    $form.find('button').prop('disabled', false);
                } else {
                    var token = response.id;
                    $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                    $form.get(0).submit();
                }
            }
        });
    </script>
@stop
