@extends('app')

@section('page-title')
    Grab a coffee
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
            <div class="row row-eq-height">
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
                <div class="col-xs-offset-3 col-xs-6 own-a-coffee text-center">
                    <h2 class="text-center">Own or manage a coffee shop?</h2>
                    <div>
                        <a href="{{ route('coffee-shop.apply') }}" class="btn btn-primary" style="background: #FF9D3A; border: 0; font-size: 18px;">Learn More</a>
                    </div>
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
