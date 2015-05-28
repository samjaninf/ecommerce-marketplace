@extends('app')

@section('content')
    <div class="container">
        <h1>Current transactions</h1>
        <ul>
            @foreach(current_user()->transactions as $t)
                <li>£ {{$t->amount / 100.}} | {{$t->created_at}}</li>
            @endforeach
        </ul>
        <a href="/charge">Charge user</a>
        <h1>Transaction of £ 5.93</h1>
        @if(!current_user()->hasStripeId())
            <form action="" method="POST" id="payment-form">
                    <span class="payment-errors">
                        {{isset($messages) ? $messages['info'] : ''}}
                    </span>

                    <div class="form-row">
                        <label>
                            <span>Card Number</span>
                            <input type="text" size="20" data-stripe="number" value="4242424242424242"/>
                        </label>
                    </div>

                    <div class="form-row">
                        <label>
                            <span>CVC</span>
                            <input type="text" size="4" data-stripe="cvc" value="999"/>
                        </label>
                    </div>

                    <div class="form-row">
                        <label>
                            <span>Expiration (MM/YYYY)</span>
                            <input type="text" size="2" data-stripe="exp-month" value="12"/>
                        </label>
                        <span> / </span>
                        <input type="text" size="4" data-stripe="exp-year" value="2020"/>
                    </div>

                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                <button type="submit">Submit Payment</button>
            </form>
        @else
        <form method="post">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
            <button type="submit">Submit Payment</button>
        </form>
        @endif
    </div>
@endsection

@section('vendor_scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@endsection

@section('scripts')
    <script type="text/javascript">
        // This identifies your website in the createToken call below
        Stripe.setPublishableKey('pk_test_i9OvcIafNOB9XIuG18lbqccm');
        // ...
        jQuery(function($) {
            $('#payment-form').submit(function(event) {
                var $form = $(this);

                // Disable the submit button to prevent repeated clicks
                $form.find('button').prop('disabled', true);

                Stripe.card.createToken($form, stripeResponseHandler);

                // Prevent the form from submitting with the default action
                return false;
            });

            function stripeResponseHandler(status, response) {
                var $form = $('#payment-form');

                if (response.error) {
                    // Show the errors on the form
                    $form.find('.payment-errors').text(response.error.message);
                    $form.find('button').prop('disabled', false);
                } else {
                    // response contains id and card, which contains additional card details
                    var token = response.id;
                    // Insert the token into the form so it gets submitted to the server
                    $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                    // and submit
                    $form.get(0).submit();
                }
            }
        });
    </script>
@endsection
