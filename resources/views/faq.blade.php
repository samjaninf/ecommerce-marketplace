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
                <h3>How does it work?</h3>
                <p>Sign up – Enter your shop details – Menu, descriptions, photos, location and opening times and start receiving orders straight away.</p>
                <p>Customers get to know your shop when searching for coffee in your area, see your details, your photos, look at your menu and check out reviews. They can then choose to order and pay online through KoolBeans or walk in store and buy from you directly.</p>
                
                <h3>How much does it cost?</h3>
                <p>It’s completely free to create your account. Koolbeans only charges 6% sales commission which is applied on sales made through KoolBeans. This excludes Stripe transaction fees. </p>

                <h3>When do I get paid?</h3>
                <p>All payments go directly to your stripe account.</p>
                
                <h3>Do I need a Stripe account?</h3>
                <p>Yes. A stripe account is a requirement for having your coffee shop on KoolBeans.</p>

                <p>KoolBeans provides a quick signup form for a Stripe account that enables you to receive payment directly. You will find the link within your KoolBeans dashboard.</p>

                <h3>How much does a Stripe account cost?</h3>
                <p>Setting up a Stripe account is free. Stripe transaction fees are automatically deducted every time a customer makes an order to your coffee shop through KoolBeans. This way you get paid faster with less hassle.</p>

                <h3>How much are Stripe transaction fees?</h3>
                <p>Stripe charges 1.4% + 20p on transactions over £4.20 (e.g. £5 order value = 27p) </p>
                <p>A micro-transaction rate of 5% + 5p on transactions under £4.20 (e.g. £2.40 order value = 17p) </p>

                <h3>Do you charge commission on sales if customers come straight to our shop without ordering on KoolBeans?</h3>
                <p>We only charge commission on orders placed through KoolBeans. We expect many people will use KB to discover new places without ordering ahead, which is another great reason to have your coffee shop on KoolBeans.</p>

                <h3>How do I receive orders?</h3>
                <p>To receive orders you only need internet (broadband, 3G or 4G), an internet connected device (smartphone, tablet, laptop/pc). KoolBeans works across all devices and there is no need for additional hardware.</p>

                <h3>How am I notified of new orders?</h3>
                <p>There are downloadable apps (ios & android) for receiving orders which will notify you as they come in (notification alert). We send an email with the order details and you will also be able to view orders on the seller dashboard on koolbeans.co.uk</p>

                <h3>When should I prepare an order?</h3>
                <p>Orders are sent through to you as soon as they have been made on koolbeans.co.uk and will either have a collection time which can be used as a guide or will be set as ‘make on arrival’. In both instances make the order when the customer has arrived in your shop. This way the customer receives the best quality product without having to worry about the customer being late or the coffee getting cold.</p>

                <h3>What if I miss an order notification?</h3>
                <p>Not to worry, we expect this will happen a lot. We will always inform customers that although we hope this doesn’t happen, to be prepared that it may do. Most of the time people are happy if they are forewarned.</p>

                <h3>What if I’m busy when an order comes through?</h3>
                <p>Again don’t panic. We will inform customers that during peak times there may be a delay in receiving their order. Please treat KoolBeans customers in the same way you would treat any other customer who has already ordered and paid. We ask that you acknowledge their order and let them know it will be made as soon as possible. </p>

                <h3>Do I need to pay VAT?</h3>
                <p>If you are VAT registered you will pay the same VAT as you would if the sale came through your own till. KoolBeans will be VAT registered and VAT will be charged on commission at the applicable rate as set out by HMRC. An itemised receipt is sent through each month so you can clearly see the VAT that has been charged on the sales in order that you can reclaim it.</p>

                <h3>Why independent coffee shops?</h3>
                <p>It’s obvious to us that you take a huge amount of pride in serving the best coffee and food to your customers and we love that. KoolBeans aims to promote this to all that haven’t discovered it yet. We also want to help coffee shops grow their customer base and grow as a community, raising the bar on the quality of the coffee we consume. For customers that already use independents, KoolBeans will be a useful tool to find new shops, offering them the convenience of ordering ahead and the ability to grow the community with helpful, honest reviews</p>

                <h3>If I sign up am I entered into a lengthy contract?</h3>
                <p>There are no contracts but you can stay as long as you want.</p>

                <h3>Can customers order when we are closed?</h3>
                <p>It is not possible to place orders outside of your shop opening times. </p>

                <h3>How do I run a special offer?</h3>
                <p>You can choose to run a special offer in the seller dashboard. The offers are pre-set to ‘buy one get one half price’. You choose which products this applies to and what times you want the offer to be in place (e.g. happy hour during a quieter time). You do not have to run any offers if you would prefer not to.</p>

                <h3>How can I track my account?</h3>
                <p>It is easy to track the success of your KoolBeans account as all users that view your shop are displayed in your dashboard, this includes customers that haven’t ordered. This is advertising where you can see all the benefits.</p>

                <h3>What is the commission rate?</h3>
                <p>Commission is 6% of the order total. This excludes Stripe fees. No other hidden fees or costs.</p>

                <h3>When do I get paid?</h3>
                <p>All payments are paid directly to your Stripe account in 7days or less.</p>

                <h3>There aren’t many coffee shops on the site from my area, should I still join?</h3>
                <p>Please bear with us. We are a start-up and are working hard to grow the independent community. Joining now will help us achieve this.</p>

                <h3>I already have a website and a twitter account can KoolBeans be linked to these?</h3>
                <p>That’s fantastic news and also a great help. Putting links on your website and social media accounts to your unique KoolBeans page will help you stand out better in searches and is a great way to increase revenue.</p>

                <h3>Can I advertise KoolBeans in my shop or window?</h3>
                <p>Yes absolutely! We will provide KoolBeans window stickers which you can place on your shop window/door. These will help KoolBeans users to recognise they have found the right shop. </p>
                
                <h3>What if I run out of stock?</h3>
                <p>You can turn items off in the seller dashboard with one click if you are running low on stock and turn them back on again when they are back in stock. </p>
                
                <h3>We love you!!</h3>
                <p>We love you too!</p>
            </div>
        </div>
    </div>
@stop
