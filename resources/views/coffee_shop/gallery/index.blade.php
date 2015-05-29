@extends('app')

@section('page-title')
    Your shop images
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @include('dashboard._title')
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-unstyled gallery">
                    @forelse($gallery as $image)
                        <li>
                            <img src="{{$coffeeShop->getUploadUrl()}}/{{$image->image}}" alt="{{$image->image}}">
                            <div class="pull-right">
                                <a href="{{ route('coffee-shop.gallery.up', ['coffee_shop' => $coffeeShop, 'gallery' => $image]) }}"
                                   class="btn btn-success"><i class="glyphicon glyphicon-arrow-up"></i></a>

                                <form method="post"
                                      action="{{route('coffee-shop.gallery.destroy', ['coffee_shop' => $coffeeShop, 'gallery' => $image])}}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </button>
                                </form>

                                <a href="{{ route('coffee-shop.gallery.down', ['coffee_shop' => $coffeeShop, 'gallery' => $image]) }}"
                                   class="btn btn-success"><i class="glyphicon glyphicon-arrow-down"></i></a>
                            </div>
                        </li>
                    @empty
                        <li>
                            <p class="alert alert-warning">No image has been added yet.</p>
                        </li>
                    @endforelse
                    <li class="text-center" style="width: 80%;">
                        <a href="{{ route('coffee-shop.gallery.create', ['coffee_shop' => $coffeeShop]) }}"
                           class="btn btn-primary">
                            Add image
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
