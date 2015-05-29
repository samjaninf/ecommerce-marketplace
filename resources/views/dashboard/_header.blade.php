<div class="row dashboard-header">
    <div class="col-sm-3 hidden-xs full-height">
        @if($firstImage)
            <img src="{{$coffeeShop->getUploadUrl() . '/' . $firstImage}}"
                 alt="Main image"
                 class="main-gallery-image">
        @endif
    </div>
    <div class="col-sm-9 col-xs-12 full-height">
        <div class="row">
            <div class="col-xs-12 full-height">
                @include('dashboard._title')
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 full-height">
                @foreach($images as $i => $image)
                    @if($i === 0)
                        <img src="{{$coffeeShop->getUploadUrl() . '/' . $image->image}}"
                             alt="Main image"
                             class="secondary-gallery-image hide visible-xs-inline">
                    @else
                        <img src="{{$coffeeShop->getUploadUrl() . '/' . $image->image}}"
                             alt="Secondary image"
                             class="secondary-gallery-image hidden-xs">
                    @endif
                @endforeach
                <a href="{{ route('coffee-shop.gallery.index', ['coffee_shop' => $coffeeShop]) }}"
                   style="margin-left: 20px">
                    Add more images<span class="hidden-sm"> / Reorganize</span>
                </a>
            </div>
        </div>
    </div>
</div>
