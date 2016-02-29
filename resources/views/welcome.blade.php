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
            <div class="row row-eq-height text-center">
                <div class="col-xs-12 col-sm-6" id="deals">
                    <div class="row">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/eAeaQXfPD3M" frameborder="0" allowfullscreen></iframe>
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
                <div class="col-xs-12 list-your-shop-overlay">
                </div>
                <div class="col-xs-offset-3 col-xs-6 own-a-coffee text-center">
                    <h2 class="text-center">Own or manage a coffee shop?</h2>
                    <div>
                        <a href="{{ route('coffee-shop.apply') }}" class="btn btn-primary" style="background: #FF9D3A; border: 0; font-size: 18px;">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid benefits-of-joining">
            <div class="row row-eq-height text-center">
                <div class="col-xs-12 col-sm-3 benefit">
                    <img src="/img/shop icon.png"/>
                    <h4>Your Shop Online</h4>
                    <p>Create your online coffee shop to match your business. Customise your page with photos, descriptions and menu</p>
                </div>
                <div class="col-xs-12 col-sm-3 benefit">
                    <img src="/img/Customer icon.png"/>
                    <h4>New Customers</h4>
                    <p>Allow new customers to find and learn more about you</p>
                </div>
                <div class="col-xs-12 col-sm-3 benefit">
                    <img src="/img/Order received icon.png"/>
                    <h4>No Hardware</h4>
                    <p>Set up and start receiving orders with just a smartphone, tablet or PC</p>
                </div>
                <div class="col-xs-12 col-sm-3 benefit">
                    <img src="/img/Heart.png"/>
                    <h4>Supporting Independent</h4>
                    <p>Independents do it better and we support that wholeheartedly. We are exclusive to independents and local chains</p>
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
