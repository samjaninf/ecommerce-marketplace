<div class="row dashboard-header">
    @if($firstImage)
    <div class="col-sm-3 hidden-xs full-height">
        
            <img src="{{$coffeeShop->getUploadUrl() . '/' . $firstImage}}"
                 alt="Main image"
                 class="main-gallery-image">
        
    </div>
    @endif
    @if($firstImage)
        <div class="col-sm-9 col-xs-12">
    @else 
        <div class="col-xs-12">
    @endif 
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
                             class="secondary-gallery-image hide visible-xs-inline pull-left">
                    @else
                        <img src="{{$coffeeShop->getUploadUrl() . '/' . $image->image}}"
                             alt="Secondary image"
                             class="secondary-gallery-image hidden-xs pull-left">
                    @endif
                @endforeach
                <div class="clearfix"></div>
                <div class="pull-left">
                    <a href="{{ route('coffee-shop.gallery.index', ['coffee_shop' => $coffeeShop]) }}">
                        Add more images<span class="hidden-sm"> / Reorganize</span>
                    </a>( The first image will be used as your profile image )<br>
                    <a href="{{ route('coffee-shop.products.index', ['coffee_shop' => current_user()->coffee_shop]) }}">
                        Access your menu
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
