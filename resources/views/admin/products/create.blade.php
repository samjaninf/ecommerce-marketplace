@extends('app')

@section('page-title')
    Add a product
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('admin.products.store') }}" class="form-horizontal" method="post" id="create-product">
            <div class="form-group @if($errors->any()) {{$errors->has('type') ? 'has-error' : 'has-success'}} @endif">
                <label for="type" class="col-sm-2 control-label">Type:</label>

                <div class="col-sm-10 col-md-6">
                    <select id="type" name="type" class="form-control">
                        <option value="drink" @if($product->type === 'drink') selected @endif>Drink</option>
                        <option value="food" @if($product->type === 'food') selected @endif>Food</option>
                    </select>
                </div>
            </div>

            <div class="form-group @if($errors->any()) {{$errors->has('name') ? 'has-error' : 'has-success'}} @endif">
                <label for="name" class="col-sm-2 control-label">Name:</label>

                <div class="col-sm-10 col-md-6">
                    <input id="name"
                           name="name"
                           type="text"
                           placeholder="Name..."
                           class="form-control"
                           value="{{old('name', $product->name)}}">
                </div>
            </div>

            <div class="form-group @if($errors->any()) {{$errors->has('product_types') ? 'has-error' : 'has-success'}} @endif">
                <div class="col-sm-offset-2 col-sm-10" id="product-types-list">
                    @foreach($foodTypes as $type)
                        <div class="hide type-food checkbox">
                            <label for="product_type-{{$type->name}}">
                                <input type="checkbox"
                                       id="product_type-{{$type->name}}"
                                       name="product_type[{{$type->name}}]"
                                @if(old('product_types.'.$type->name)) checked @endif> {{$type->name}}
                            </label>
                        </div>
                    @endforeach
                    @foreach($drinkTypes as $type)
                        <div class="hide type-drink checkbox">
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
                    <label>
                        <input type="text" id="add-type" class="form-control" placeholder="New type">
                    </label>
                    <button id="add-type-trigger" class="btn btn-default" style="margin-top: -1px">Add</button>
                </div>
            </div>

            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-success" value="Add a product">
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ elixir('js/admin.js') }}"></script>
@endsection
