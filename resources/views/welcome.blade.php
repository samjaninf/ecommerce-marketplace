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
                            <h2>Our offers</h2>
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
                    <h2 class="text-center">Are you a coffee shop?</h2>
                    <h4 class="text-center">People are changing the way they buy, so join them...</h4>
                </div>
                <p class="col-xs-12 col-sm-6 col-md-6 col-lg-offset-3 col-lg-3">
                    KoolBeans puts your Coffee Shop online 24 hours a day, 7 days a week.
                    By listing your business with KoolBeans,
                    you’re gaining access to millions of UK coffee drinkers
                    who browse and purchase online everyday of the week.
                </p>

                <p class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    We’ll get you listed in no time with our easy to use system – we’ll upload your menu,
                    handle your online orders and even sort out the payment,
                    so all you need to do is to serve the coffee.
                </p>

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
