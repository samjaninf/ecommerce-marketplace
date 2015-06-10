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
                        </div>
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
