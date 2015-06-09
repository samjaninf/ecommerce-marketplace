@extends('app')

@section('page-title')
    Edit the {{$product->type}} {{$product->name}}
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('admin.products.update', ['product' => $product]) }}" class="form-horizontal" method="post" id="create-product">
            <input type="hidden" name="_method" value="put">
            @include('admin.products._form')

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-success" value="Update the product">
                </div>
            </div>
        </form>
    </div>
@endsection
