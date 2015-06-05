<table class="table table-menu">
    <thead>
    <tr>
        <th>Name</th>
        @if(count($sizes) === 4)
            <th><a href="#">Small</a></th>
            <th><a href="changeTerm">Medium</a></th>
            <th><a href="changeTerm">Large</a></th>
            <th><a href="changeTerm">Extra Large</a></th>
        @else
            <th><a href="#">Price</a></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>
                <label for="product-{{$product->id}}">
                    <input id="product-{{$product->id}}"
                           class="activates"
                           type="checkbox"
                           value="{{$product->id}}"
                           data-target="{{ route('coffee-shop.products.toggle', ['coffeeShop' => $coffeeShop, 'product' => $product]) }}"
                           @if($coffeeShop->hasActivated($product) !== false) checked @endif>
                </label>
                <span>
                    <a href="#"
                       class="change-display-name"
                       data-target="{{ route('coffee-shop.products.rename', ['coffeeShop' => $coffeeShop, 'product' => $product]) }}">
                        {{ $coffeeShop->getNameFor($product) }}
                    </a>
                    (Default: {{ $product->name }})
                </span>
            </td>
            @foreach($sizes as $size)
                <td>
                    @if(count($sizes) === 4)
                        <label for="product-{{$product->id}}-{{$size}}">
                            <input id="product-{{$product->id}}-{{$size}}"
                                   class="activates"
                                   type="checkbox"
                                   value="{{$product->id}}"
                                   data-target="{{ route('coffee-shop.products.toggle', ['coffeeShop' => $coffeeShop, 'product' => $product, 'size' => $size]) }}"
                                   @if($coffeeShop->hasActivated($product, $size) !== false) checked @endif>
                        </label>
                    @endif
                    <span>
                        <a href="#"
                           class="change-price"
                           data-target="{{ route('coffee-shop.products.reprice', ['coffeeShop' => $coffeeShop, 'product' => $product, 'size' => $size]) }}">
                            {{ current_user()->coffee_shop->priceFor($product, $size) }}
                        </a>
                    </span>
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
