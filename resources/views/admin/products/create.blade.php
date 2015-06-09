@extends('app')

@section('page-title')
    Add a product
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('admin.products.store') }}" class="form-horizontal" method="post" id="create-product">
            @include('admin.products._form')

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-success" value="Add a product">
                </div>
            </div>
        </form>
    </div>
@endsection
