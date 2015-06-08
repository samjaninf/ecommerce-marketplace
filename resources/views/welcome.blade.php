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
