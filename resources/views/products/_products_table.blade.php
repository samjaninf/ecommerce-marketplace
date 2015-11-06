<table class="table table-menu">
    <thead>
    <tr>
        <th>Name</th>
        @if(count($sizes) === 4)
            <th><a href="#">Small</a></th>
            <th><a href="#">Medium</a></th>
            <th><a href="#">Large</a></th>
            <th><a href="#">Extra Large</a></th>
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
                           class="activates "
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
                    (Default: {{ $product->name }})<br>
                  
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
        <tr>
           <td colspan="5" style="border-top:0px">
                <span>
                    Description: <a href="#"
                                    class="change-description"
                                    data-target="{{ route('coffee-shop.products.change-description', ['coffeeShop' => $coffeeShop, 'product' => $product]) }}">
                        {{ $coffeeShop->getDescriptionFor($product) }}
                    </a>
                </span>
            </td>
        </tr>
    @endforeach
    <tr>
        <td class="success" colspan="{{count($sizes) + 2}}">
            <a href="#" data-target="form-add-{{count($sizes) == 4 ? 'drink' : 'food' }}" class="add-product">Add a new
                product</a>

            <form action="{{ route('products.store') }}"
                  id="form-add-{{count($sizes) == 4 ? 'drink' : 'food' }}"
                  class="hide"
                  method="post">
                <div class="form-group @if($errors->any()) {{$errors->has('name') ? 'has-error' : 'has-success'}} @endif">
                    <label for="name" class="col-sm-2 control-label">Name:</label>

                    <div class="col-sm-10 col-md-6">
                        <input id="name"
                               name="name"
                               type="text"
                               placeholder="Name..."
                               class="form-control"
                               value="{{old('name')}}">
                    </div>
                </div>

                <div class="form-group @if($errors->any()) {{$errors->has('product_types') ? 'has-error' : 'has-success'}} @endif">
                    <div class="col-sm-offset-2 col-sm-10" id="product-types-list">
                        @foreach($types as $type)
                            <div class="type-drink checkbox">
                                <label for="product_type-{{$type->name}}">
                                    <input type="checkbox"
                                           id="product_type-{{$type->name}}"
                                           name="product_type[{{$type->name}}]"
                                           @if(old('product_types.'.$type->name)) checked @endif> {{$type->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden"
                               name="type"
                               value="{{ count($sizes) == 4 ? 'drink' : 'food' }}"
                               id="type-field">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                        <input type="submit" class="btn btn-success" value="Add a product">
                    </div>
                </div>
            </form>
        </td>
    </tr>
    </tbody>
</table>
