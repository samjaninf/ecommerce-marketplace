@extends('app')

@section('page-title')
    Results for {{$query}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="visible-xs-block visible-sm-block row">
            <div class="search-results-title">
                @include('search._result_title')
            </div>

            <div class="maps-container hidden-xs hidden-sm" data-position="{{$position}}" style="max-height: 400px"></div>

            @foreach($shops as $shop)
                @include('coffee_shop._small', ['showXs' => true, 'size' => 'col-sm-6 col-xs-6 col-very-xs-12', 'coffeeShop' => $shop])
            @endforeach

           <div class="col-xs-12">
               <div class="pull-right">
                   @if($shops !== [])
                       {!! $shops->render() !!}
                   @endif
               </div>
           </div>

        </div>

        <div class="hidden-xs hidden-sm row">
            <div class="col-md-6" style="padding: 0">
                <div class="search-results-title">
                    @include('search._result_title')
                </div>

                <div class="search-results row">
                    @forelse($shops as $coffeeShop)
                        <div class="col-md-12 col-lg-6">
                            <div class="featured-coffee-shop"
                                 style="height: 300px; background-image: url({{$coffeeShop->mainImage() }})"
                                 data-latitude="{{ $coffeeShop->latitude }}"
                                 data-longitude="{{ $coffeeShop->longitude }}">
                                <div class="info small-featured" style="height: 55%; padding-left: 20px">
                                    <h4 class="text-left">
                                        {{ $coffeeShop->name }}
                                    </h4>

                                    <p style="text-align: left">
                                        <i>{{ $coffeeShop->location }}
                                            ({{ number_format($coffeeShop->getDistance(), 2) }} miles)</i>
                                    </p>
                                    @include('coffee_shop._rating', ['rating' => $coffeeShop->getRating()])
                                    <div class="review hidden-sm hidden-xs">
                                        {{ $coffeeShop->getBestReview() ? $coffeeShop->getBestReview()->pivot->review : null}}
                                    </div>
                                    <div class="actions text-center" style="margin-left: -20px">
                                        <a href="{{ route('coffee-shop.order.create', ['coffeeShop' => $coffeeShop]) }}"
                                           class="btn btn-success">Order <span class="hidden-xs"> a Coffee </span></a>
                                        <a href="{{ route('coffee-shop.show', ['coffeeShop' => $coffeeShop]) }}"
                                           class="btn btn-primary">View <span class="hidden-xs">Profile</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            No result found!
                        </div>
                    @endforelse
                </div>

                @if($shops !== [])
                    <div class="col-xs-12">
                        <div class="pull-right">
                            {!! $shops->render() !!}
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-6 maps-container no-marker" @if(!\Request::has('location')) data-position="{{ $position }}" @endif></div>
        </div>
    </div>
@endsection
