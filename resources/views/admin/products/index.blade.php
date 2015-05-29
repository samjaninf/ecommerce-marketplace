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
                        <tr>
                            <td>{{$drink->id}}</td>
                            <td>#</td>
                            <td>#</td>
                            <td>#</td>
                            <td>
                                #
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
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>#</td>
                            <td>#</td>
                            <td>#</td>
                            <td>
                                #
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
