@extends('app')

@section('page-title')
    Add an image to your shop
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @include('dashboard._title')
            </div>
        </div>
        <form action="{{ route('coffee-shop.gallery.store', ['coffee_shop' => $coffeeShop]) }}"
              method="post"
              enctype="multipart/form-data">
            <div class="form-group @if($errors->any()) {{$errors->has('image') ? 'has-error' : 'has-success'}} @endif">
                <input type="submit" class="col-sm-2 btn btn-success btn-xs" value="Upload">
                <label for="image" class="col-sm-1">Image:</label>

                <input id="image"
                       name="image"
                       type="file"
                       placeholder="Image..."
                       class="col-sm-6">
            </div>

            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
        </form>
    </div>
@endsection
