@extends('app')

@section('page-title')
    Reporting
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    @yield('page-title')
                    <span id="page-actions">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">All products</a>
                        <a href="{{ route('admin.post.index') }}" class="btn btn-primary">All posts</a>
                        <a href="{{ route('admin.post.index') }}" class="btn btn-default">Go back</a>
                    </span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-3">
                        <label for="dateGoTo">
                            Show stats after the
                        </label>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <input id="dateGoTo" type="date" class="form-control">
                    </div>
                    <a href="#" onclick="goToDate()" class="btn btn-primary col-xs-3">
                        Go >
                    </a>
                </div>

                <table class="table table-hovered">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Total sold for</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->product_name }}</td>
                            <td>£ {{ number_format($sale->aggregate / 100., 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        function goToDate() {
            var date = $('#dateGoTo').val();

            window.location = "{{ route('admin.reporting') }}/" + date;
        }
    </script>
@stop
