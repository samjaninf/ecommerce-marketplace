@extends('app')

@section('page-title')
    Order great coffee, from great coffee shops
@endsection

@section('splash')
    @include('welcome._splash')
    <div class="clearfix"></div>
@endsection

@section('content')
    <div id="welcome">
        <div class="container-fluid" id="features">
            @include('welcome._features')
        </div>

        <div class="container-fluid" id="coffee-shops">
            <div class="row">
                <div class="col-xs-12">
                    <div class="container">
                        @include('coffee_shop._featured')
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid" id="deals-and-news">
            <div class="row">
                <div class="col-xs-12 col-sm-6" id="deals">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h2>Today’s offers</h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            @include('offers._short', ['offer' => $offers[0], 'bgNum' => 1])
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            @include('offers._short', ['offer' => $offers[1], 'bgNum' => 2])
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            @include('offers._short', ['offer' => $offers[2], 'bgNum' => 3])
                        </div>
                        <div class="hidden-xs hidden-sm hidden-md col-lg-6">
                            @include('offers._short', ['offer' => $offers[3], 'bgNum' => 4])
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6" id="news">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h2>Latest news</h2>

                            <div style="position: relative">
                                @foreach($posts as $post)
                                    @include('posts._small')
                                @endforeach
                            </div>

                            <a href="{{ route('posts.index') }}" class="btn btn-default" style="margin-top: 30px">View all news</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container-fluid are-you-a-coffee-shop">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="text-center">Own or manage a coffee shop?</h2>
                    <h4 class="text-center">People are changing the way they buy. So join them...</h4>
<p style="font-size: 17px;" class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-offset-3 col-lg-6 ">Joining the KoolBeans network of  independent and small chain coffee shops is the easiest way to put your business online. We’ll have you listed in no time.
</p>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-offset-3 col-lg-3" style="font-size: 17px;">
                    <p>What we do: </p>
                    <ul>
                        <li>Your Coffee Shop is online 24/7 and easily viewable to millions of UK coffee drinkers </li>
                        <li>Customers can browse and purchase from your store online  - we notify you of orders that are made </li>
                        <li>We process all payments online saving you time and expense </li>
                        <li>We simplify your online business by seamlessly integrating it into  your normal day to day operating </li>
                        <li>We market your shop  over several social media platforms including facebook and twitter and make it easy for customers to find you on google </li>
                        <li>Your Coffee Shop is online 24/7 and easily viewable to millions of UK coffee drinkers </li>
                    </ul>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="font-size: 17px;">
                    <p>How it works: </p>
                    <ul>
                        <li>Upload details and pictures of your coffee shop including your menu, allowing customers to familiarise themselves with your store</li>
                        <li>Begin receiving orders  - Notifications are sent through real time to your store via a downloadable ios /android app or by email  </li>
                        <li>Customers collect their order in store either on arrival or at their collection time</li>
                        <li>The full sales amount is paid to you every 14days less a small commission which includes transaction fees and costs. </li>
                    </ul>
                </div>

                <div class="col-xs-12 text-center">
                    <a href="{{ route('coffee-shop.apply') }}" class="btn btn-primary">Sign up now</a><br/>
                    <a href="{{ url('/about') }}" class="btn btn-default">More info</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        (function ($) {
            $('#main-menu').find('> ul > li > a').each(function () {
                this.style.color = '#fff';
            });
        })(jQuery);
    </script>
@stop
