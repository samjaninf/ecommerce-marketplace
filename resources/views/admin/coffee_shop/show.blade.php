@extends('app')

@section('page-title')
    @if($coffeeShop->status === 'requested')Review @endif {{$coffeeShop->name}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    @yield('page-title')
                    @if($coffeeShop->isPublished())
                        <span class="btn btn-success normal-pointer">
                            Live
                        </span>
                    @endif
                    <span>
                        <a href="{{ route('admin.coffee-shop.index') }}">List shops</a>
                    </span>
                    <span id="page-actions">
                        @if($coffeeShop->status === 'requested')
                            <a href="{{route('admin.coffee-shop.show', ['coffee_shop' => $previous])}}"
                               class="btn btn-default @if($previous->id === $coffeeShop->id) disabled @endif">Previous</a>
                            <a href="{{route('admin.coffee-shop.review', ['coffee_shop' => $coffeeShop, 'status' => 'accepted'])}}"
                               class="btn btn-success"
                               data-confirm="Have you called them to verify it was them?">Accept</a>
                            <a href="{{route('admin.coffee-shop.review', ['coffee_shop' => $coffeeShop, 'status' => 'declined'])}}"
                               class="btn btn-warning">Decline</a>
                            <a href="{{route('admin.coffee-shop.show', ['coffee_shop' => $next])}}"
                               class="btn btn-default @if($next->id === $coffeeShop->id) disabled @endif">Next</a>
                        @else
                            <a href="{{route('admin.coffee-shop.review', ['coffee_shop' => $coffeeShop, 'status' => 'requested'])}}"
                               class="btn btn-warning">Put on hold</a>
                            @if($coffeeShop->isPublished())
                                <a href="{{ route('admin.coffee-shop.featured', ['coffee_shop' => $coffeeShop]) }}"
                                   class="btn btn-{{$coffeeShop->featured ? 'warning' : 'success'}}">
                                    {{$coffeeShop->featured ? 'Unset ' : 'Set as '}} featured
                                </a>
                            @endif
                        @endif
                    </span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="label label-{{$coffeeShop->isPublished() ? 'success' : 'default'}} hidden-xs">
                            Name
                        </span> {{$coffeeShop->name ?: '#'}}
                    </li>
                    <li class="list-group-item">
                        <span class="label label-{{$coffeeShop->isPublished() ? 'success' : 'default'}} hidden-xs">
                            Contact
                        </span> {{$coffeeShop->user->name ?: '#'}}
                    </li>
                    <li class="list-group-item">
                        <span class="label label-{{$coffeeShop->isPublished() ? 'success' : 'default'}} hidden-xs">
                            Phone Number
                        </span> {{$coffeeShop->phone_number ?: '#'}}
                    </li>
                    <li class="list-group-item">
                        <span class="label label-{{$coffeeShop->isPublished() ? 'success' : 'default'}} hidden-xs">
                            Address
                        </span> {{$coffeeShop->location ?: '#'}}
                    </li>
                    <li class="list-group-item">
                        <span class="label label-{{$coffeeShop->isPublished() ? 'success' : 'default'}} hidden-xs">
                            Postal code
                        </span> {{$coffeeShop->postal_code ?: '#'}}
                    </li>
                    @if($coffeeShop->isValid() && ! $coffeeShop->isPublished())
                        <li class="list-group-item list-group-item-warning">
                            This coffee shop has been accepted but is not yet published.
                            <a href="mailto:{{ $coffeeShop->user->email }}">Contact the owner</a>
                        </li>
                    @endif
                </ul>
                <a href="https://www.google.co.uk/search?q={{$coffeeShop->location}}"
                   target="_blank"
                   class="btn btn-primary">
                    Verify on google
                </a>
            </div>

            <div class="col-lg-4">
                <div id="maps-container" data-position="{{$coffeeShop->latitude}},{{$coffeeShop->longitude}}"></div>
            </div>
        </div>
    </div>
@endsection

@section('vendor_scripts')
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ elixir('js/gmaps.js')}}"></script>
@endsection
