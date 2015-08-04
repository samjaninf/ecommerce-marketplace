@extends('app')

@section('page-title')
    Results for {{$query}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="visible-xs-block row">
            <div class="search-results-title">
                @include('search._result_title')
            </div>

            <div class="maps-container" data-position="{{$position}}"></div>

            @foreach($shops as $shop)
                @include('coffee_shop._small', ['showXs' => true, 'coffeeShop' => $shop])
            @endforeach

            <div class="pull-right container">
                @if($shops !== [])
                    {!! $shops->render() !!}
                @endif
            </div>

        </div>

        <div class="hidden-xs row">
            <div class="col-sm-6" style="padding: 0">
                <div class="search-results-title">
                    @include('search._result_title')
                </div>

                <div class="search-results row">
                    @forelse($shops as $coffeeShop)
                        <div class="col-sm-6">
                            <div class="featured-coffee-shop"
                                 style="height: 450px; background-image: url({{$coffeeShop->mainImage() }})"
                                 data-latitude="{{ $coffeeShop->latitude }}"
                                 data-longitude="{{ $coffeeShop->longitude }}">
                                <div class="info small-featured text-center" style="height: 45%">
                                    <h5 class="text-center">
                                        {{ $coffeeShop->name }}
                                    </h5>

                                    <p>
                                        <i>{{ $coffeeShop->location }}
                                            ({{ number_format($coffeeShop->getDistance(), 2) }} miles)</i>
                                    </p>
                                    @include('coffee_shop._rating', ['rating' => $coffeeShop->getRating()])
                                    <div class="review hidden-sm hidden-xs">
                                        {{ $coffeeShop->getBestReview() ? $coffeeShop->getBestReview()->pivot->review : null}}
                                    </div>
                                    <div class="actions">
                                        <a href="{{ route('coffee-shop.order.create', ['coffeeShop' => $coffeeShop]) }}"
                                           class="btn btn-success">Order <span class="hidden-xs"> a Coffee </span></a>
                                        <a href="{{ route('coffee-shop.show', ['coffeeShop' => $coffeeShop]) }}"
                                           class="btn btn-primary">View <span class="hidden-xs">Profile</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-sm-6">
                            No result found!
                        </div>
                    @endforelse
                </div>

                @if($shops !== [])
                    <div class="pull-right">
                        {!! $shops->render() !!}
                    </div>
                @endif
            </div>

            <div class="col-sm-6 maps-container no-marker" @if($lat !== false) data-position="{{ $position }}" @endif></div>
        </div>
    </div>
@endsection

@section('vendor_scripts')
    <script type="text/javascript" src="//www.google.com/recaptcha/api.js"></script>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
@endsection
