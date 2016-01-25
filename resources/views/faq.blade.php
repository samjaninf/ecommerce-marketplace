@extends('app')

@section('page-title')
    Sign Up FAQ's
@endsection

@section('content')
    <style>
        li {
            font-family: "Open Sans Light", Helvetica, Arial, sans-serif;
        }
    </style>

    <div class="container main-content-padded">
        <div class="row">
            <div class="col-xs-12">
                <h1>@yield('page-title')</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 faq" style="font-weight: bold;">
                <h3>How much does it cost?</h3>
                <p>It’s completely free to create your account. Koolbeans only charges 6% sales commission which is applied on sales made through KoolBeans. This excludes Stripe transaction fees.</p>

                <h3>When do I get paid?</h3>
                <p>All payments go directly to your stripe account.</p>

                <h3>Do I need a Stripe account?</h3>
                <p>Yes. A stripe account is a requirement for having your coffee shop on KoolBeans.</p>
                <p>KoolBeans provides a quick signup form for a Stripe account that enables you to receive payment directly. You will find the link within your KoolBeans dashboard.</p>

                <h3>How much does a Stripe account cost?</h3>
                <p>Setting up a Stripe account is free. KoolBeans sales commission and stripe transaction fees are automatically deducted every time a customer makes an order to your coffee shop. This way you get paid faster with less hassle.</p>

                <h3>How much are Stripe transaction fees?</h3>
                <p>Stripe charges 1.4% + 20p on transactions over £4.20 (e.g. £5 order value = 27p)</p>
                <p>A micro-transaction rate of 5% + 5p on transactions under £4.20 (e.g. £2.40 order value = 17p)</p>

                <h3>Do I need to pay VAT?</h3>
                <p>If you are VAT registered you will pay the same VAT as you would if the sale came through your own till. KoolBeans will be VAT registered and VAT will be charged on commission at the applicable rate as set out by HMRC. An itemised receipt is sent through each month so you can clearly see the VAT that has been charged on the sales in order that you can reclaim it.</p>

                <h3>Why independent coffee shops?</h3>
                <p>It’s obvious to us that you take a huge amount of pride in serving the best coffee and food to your customers and we love that. KoolBeans aims to promote this to all that haven’t discovered it yet. We also want to help coffee shops grow their customer base and grow as a community, raising the bar on the quality of the coffee we consume. For customers that already use independents, KoolBeans will be a useful tool to find new shops, offering them the convenience of ordering ahead and the ability to grow the community with helpful, honest reviews.</p>
                <h3>If I sign up am I entered into a lengthy contract?</h3>
                <p>There are no contracts but you can stay as long as you want.</p>

                <h3>If I sign up am I entered into a lenghty contract?</h3>
                <p>There are no contracts but you can stay as long as you want.</p>

                <h3>How can I track my account?</h3>
                <p>It is easy to track the success of your KoolBeans account as all users that view your shop are displayed in your dashboard, this includes customers that haven’t ordered. This is advertising where you can see all the benefits.</p>

                <h3>What is the commission rate?</h3>
                <p>Commission is 6% of the order total. This excludes Stripe fees. No other hidden fees or costs.</p>

                <h3>When do I get paid?</h3>
                <p>All payments are paid directly to your Stripe account in 7days or less.</p>
            </div>
        </div>
    </div>
@stop
