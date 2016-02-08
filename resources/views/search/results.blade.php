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

            @forelse($shops as $shop)
                @include('coffee_shop._small', ['showXs' => true, 'size' => 'col-sm-6 col-xs-6 col-very-xs-12', 'coffeeShop' => $shop])
            @empty
                <div class="col-md-12">
                    <h2>No results found, do you know a good coffee shop?</h2>
                    <div class="col-xs-12">
                        <form action="" method="post" enctype="text/plain">
                            <div class="form-group">
                                <label for="shopName">Coffee Shop:</label>
                                <input type="text" class="form-control" id="shopName" placeholder="Shop Name...">
                            </div>
                            <div class="form-group">
                                <label for="location">Location:</label>
                                <input type="text" class="form-control" id="location" placeholder="Location...">
                            </div>
                            <div class="form-group">
                                <label for="about">Why are you recommending this shop?</label>
                                <textarea style="min-height: 100px;" class="form-control" name="about" id="about"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            @endforelse
           <div class="col-xs-12">
               <div class="pull-right">
                   @if($shops !== [])
                       {!! $shops->render() !!}
                   @endif
               </div>
           </div>

        </div>


        <div class="hidden-xs hidden-sm row" style="padding: 15px 0px;">
            <div class="col-md-7" style="padding: 0">
                <div class="search-results-title">
                    @include('search._result_title')
                </div>
                
                <div class="search-results row">
                    @forelse($shops as $coffeeShop)

                        <div class="col-md-12 col-lg-6">
                            <div class="featured-coffee-shop"
                                 style="height: 300px; background-image: url({{$coffeeShop->mainImage() }})"
                                 data-latitude="{{ $coffeeShop->latitude }}"
                                 data-longitude="{{ $coffeeShop->longitude }}"
                                 data-title="{{ $coffeeShop->name }}"
                                 data-id="{{ $coffeeShop->id }}">
                                <div class="info small-featured" style="height: 55%; padding-left: 20px">
                                    <h4 class="text-left">
                                        {{ $coffeeShop->name }}
                                    </h4>

                                    <p style="text-align: left">
                                        <i>{{ $coffeeShop->location }}</i>
                                    </p>
                                    @include('coffee_shop._rating', ['rating' => $coffeeShop->getRating()])

                                    <div class="actions text-center" style="margin-left: -20px">
                                        <a href="{{ route('coffee-shop.show', ['coffeeShop' => $coffeeShop]) }}"
                                           class="btn btn-primary">Order <span class="hidden-xs">a Coffee</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <h2>No results found, do you know a good coffee shop?</h2>
                            <div class="col-xs-12">
                                <form action="" method="post" enctype="text/plain">
                                    <div class="form-group">
                                        <label for="shopName">Coffee Shop:</label>
                                        <input type="text" class="form-control" id="shopName" placeholder="Shop Name...">
                                    </div>
                                    <div class="form-group">
                                        <label for="location">Location:</label>
                                        <input type="text" class="form-control" id="location" placeholder="Location...">
                                    </div>
                                    <div class="form-group">
                                        <label for="about">Why are you recommending this shop?</label>
                                        <textarea style="min-height: 100px;" class="form-control" name="about" id="about"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
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

            <div class="col-md-5 maps-container no-marker" @if(!\Request::has('location')) data-position="{{ $position }}" @endif></div>
        </div>
    </div>
@endsection