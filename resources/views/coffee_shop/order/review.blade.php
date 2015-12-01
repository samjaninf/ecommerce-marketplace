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
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 col-sm-offset-2 col-md-offset-2 col-lg-offset-3" id="order-inner">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Your order</th>
                        <th>Total: £ {{number_format($order->price / 100., 2)}}</th>
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

                <h4>Pickup time: {{$order->pickup_time}}</h4>
                    <form accept-charset="UTF-8"
                          action="{{ route('coffee-shop.order.checkout', ['coffeeShop' => $coffeeShop, 'order' => $order]) }}"
                          class="require-validation @if(current_user()->hasStripeId()) hide @endif"
                          data-cc-on-file="false"
                          id="payment-form"
                          method="post">
                        <div class="form-row">
                            <div class="col-xs-12 form-group required">
                                <label class="control-label">Name on Card</label>
                                <input class="form-control" size="4" type="text" title="Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-xs-12 form-group card required">
                                <label class="control-label">Card Number</label>
                                <input data-stripe="number"
                                       placeholder="1234123412341234"
                                       class="form-control card-number"
                                       size="20"
                                       type="text">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-xs-4 form-group cvc required">
                                <label class="control-label">CVC</label>
                                <input data-stripe="cvc"
                                       class="form-control card-cvc"
                                       placeholder="ex. 311"
                                       size="4"
                                       type="text">
                            </div>
                            <div class="col-xs-4 form-group expiration required">
                                <label class="control-label">Expiration</label>
                                <input class="form-control card-expiry-month"
                                       data-stripe="exp-month"
                                       placeholder="MM"
                                       size="2"
                                       type="text">
                            </div>
                            <div class="col-xs-4 form-group expiration required">
                                <label class="control-label"> </label>
                                <input class="form-control card-expiry-year"
                                       data-stripe="exp-year"
                                       placeholder="YYYY"
                                       size="4"
                                       type="text">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 form-group">
                                <button class="form-control btn btn-primary submit-button" type="submit">Pay »</button>
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
                    <form method="post"
                          class="@if(!current_user()->hasStripeId()) hide @endif"
                          id="existingCardForm"
                          action="{{ route('coffee-shop.order.checkout', ['coffeeShop' => $coffeeShop, 'order' => $order]) }}">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                        <button class="btn btn-success" type="submit">Submit Payment</button>
                        <a href="#" class="btn btn-default" id="changeCard">Change card</a>
                    </form>
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
                    $form.find('.payment-errors').text(response.error.message);
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
