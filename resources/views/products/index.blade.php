@extends('app')

@section('page-title')
    Set up your menu
@stop

@section('content')
    <div class="container-fluid">
        @include('dashboard._header')
        <div class="row">
            <div class="col-sm-3">
                @include('dashboard._menu')
            </div>
            <div class="col-sm-9 main-content-padded">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Instructions
                            </div>
                            <div class="panel-body">
                                Each product can be activated by clicking on the "On/Off" button. <br>
                                Click the currency symbol (‘£’) next to each size you have
                                turned on and enter a price for this item. <br>
                                You are not required to activate all the sizes,
                                but you must enter a price above £0.00 for each one activated,
                                otherwise they will not show up in your menu.
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#drinks" aria-controls="drinks" role="tab" data-toggle="tab">Drinks</a>
                        </li>
                        <li role="presentation">
                            <a href="#food" aria-controls="food" role="tab" data-toggle="tab">Food</a>
                        </li>
                        <li role="presentation">
                            <a href="#offers" aria-controls="offers" role="tab" data-toggle="tab">Offers</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="drinks">
                        @include('products._products_table', ['products' => $drinks, 'types' => $drinkTypes, 'sizes' => ['xs', 'sm', 'md', 'lg']])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="food">
                        @include('products._products_table', ['products' => $food, 'types' => $foodTypes, 'sizes' => ['sm']])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="offers">
                        @include('offers._offers_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $('.activates').each(function () {
            $.fn.bootstrapSwitch.defaults.onColor = 'success';
            $.fn.bootstrapSwitch.defaults.size = 'mini';
            $(this).bootstrapSwitch();
        });
    </script>
@endsection
