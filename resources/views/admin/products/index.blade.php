@extends('app')

@section('page-title')
    Products available
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>@yield('page-title')</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>Drinks</h2>
                <hr>
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Coffee shops using it</th>
                        <th>Average price</th>
                        <th>Total profit</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($drinks as $drink)
                        <tr @if($drink->trashed()) class="warning" @endif>
                            <td>
                                <a data-toggle="tooltip"
                                   data-placement="top"
                                   title="{{ $drink->getTypesName(', ') }}">
                                    {{$drink->name}}
                                </a>
                            </td>
                            <td>#</td>
                            <td>#</td>
                            <td>#</td>
                            <td>
                                <a href="{{ route('admin.products.edit', ['product' => $drink] )}}"
                                   class="btn btn-xs btn-primary">Edit</a>
                                @if($drink->trashed())
                                    <a href="{{ route('admin.products.enable', ['product' => $drink]) }}"
                                       class="btn btn-xs btn-success">Enable</a>
                                @else
                                    <a href="{{ route('admin.products.destroy', ['product' => $drink]) }}"
                                       class="btn btn-xs btn-danger"
                                       data-method="delete"
                                       data-confirm="Deleting a product is too dangerous and, therefore, you can only disable it. Are you sure to do it, though?">
                                        Disable
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="danger">
                            <td colspan="5">No drink available</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="5" class="info text-center">
                            <a href="{{ route('admin.products.create', ['type' => 'drink']) }}">Add a drink</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>Food</h2>
                <hr>
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Coffee shops using it</th>
                        <th>Average price</th>
                        <th>Total profit</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($food as $product)
                        <tr @if($product->trashed()) class="warning" @endif>
                            <td>
                                <a data-toggle="tooltip"
                                   data-placement="top"
                                   title="{{ $product->getTypesName(', ') }}">
                                    {{$product->name}}
                                </a>
                            </td>
                            <td>#</td>
                            <td>#</td>
                            <td>#</td>
                            <td>
                                <a href="{{ route('admin.products.edit', ['product' => $drink] )}}"
                                   class="btn btn-xs btn-primary">Edit</a>
                                @if($product->trashed())
                                    <a href="{{ route('admin.products.enable', ['product' => $product]) }}"
                                       class="btn btn-xs btn-success">Enable</a>
                                @else
                                    <a href="{{ route('admin.products.destroy', ['product' => $product]) }}"
                                       class="btn btn-xs btn-danger"
                                       data-method="delete"
                                       data-confirm="Deleting a product is too dangerous and, therefore, you can only disable it. Are you sure to do it, though?">
                                        Disable
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="danger">
                            <td colspan="5">No food available</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="5" class="info text-center">
                            <a href="{{ route('admin.products.create', ['type' => 'food']) }}">Add some food</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
