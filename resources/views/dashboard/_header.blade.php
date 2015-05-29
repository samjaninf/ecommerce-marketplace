<div class="row dashboard-header">
    <div class="col-sm-3 hidden-xs full-height">
        <img src="" alt="Main image" class="main-gallery-image">
    </div>
    <div class="col-sm-9 col-xs-12 full-height">
        <div class="row">
            <div class="col-xs-12 full-height">
                @include('dashboard._title')
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 full-height">
                <img src="" alt="Main image" class="secondary-gallery-image hide visible-xs-inline">
                <img src="" alt="Secondary image" class="secondary-gallery-image hidden-xs">
                <img src="" alt="Secondary image" class="secondary-gallery-image hidden-xs">
                <a href="{{ route('coffee-shop.gallery.index', ['coffee_shop' => $coffeeShop]) }}"
                   style="margin-left: 20px">
                    Add more<span class="hidden-sm"> / Reorganize</span>
                </a>
            </div>
        </div>
    </div>
</div>
