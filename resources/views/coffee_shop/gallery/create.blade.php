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
                <input id="image"
                       name="image"
                       type="file"
                       placeholder="Image..."
                       style="display: none">
                <button class="btn btn-primary" style="width: 50%" id="choose-image">Choose image</button>
                <p>Please upload large images (at least 980px wide) to ensure that they will display properly.</p>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-lg disabled" value="Upload" style="width: 50%">
            </div>
            <div class="form-group">
                <p>
                    This is what your image looks like.
                </p>
                <img id="uploadPreview" style="width: 100%; height: 400px" src="/img/awaiting-image.png">
                <span class="text-center">Main image on your profile page</span>
            </div>
            <div class="form-group">
                <div>
                    <img id="uploadSmallPreview" style="width: 30%; height: 250px;" src="/img/awaiting-image.png">
                    <img id="uploadSmallPreview2" style="width: 50%; height: 250px;" src="/img/awaiting-image.png">
                </div>
                <div>
                    <span class="text-center" style="display: inline-block; width: 30%">Small image, used in search results</span>
                    <span class="text-center" style="display: inline-block; width: 50%">Normal sized image, used in some cards</span>
                </div>
            </div>

            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            var image    = document.getElementById("image");

            $('#choose-image').on('click', function () {
                $(image).click();
                return false;
            });

            image.onchange = function () {
                var oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);
                $('input[type=submit]').removeClass('disabled');

                oFReader.onload = function (oFREvent) {
                    document.getElementById("uploadPreview").src      = oFREvent.target.result;
                    document.getElementById("uploadPreview").style.height = "auto";
                    document.getElementById("uploadSmallPreview").src = oFREvent.target.result;
                    document.getElementById("uploadSmallPreview2").src = oFREvent.target.result;
                };
            }
        })();
    </script>
@stop
