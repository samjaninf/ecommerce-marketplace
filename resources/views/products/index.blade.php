@extends('app')

@section('page-title')
    Set up your menu
@stop

@section('content')
    <div class="container">
        <div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#drinks" aria-controls="drinks" role="tab" data-toggle="tab">Drinks</a>
                </li>
                <li role="presentation">
                    <a href="#food" aria-controls="food" role="tab" data-toggle="tab">Food</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="drinks">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th><a href="changeTerm">Small</a></th>
                        <th><a href="changeTerm">Medium</a></th>
                        <th><a href="changeTerm">Large</a></th>
                        <th><a href="changeTerm">Extra Large</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($drinks as $drink)
                        <tr>
                            <td>
                                <a href="#" class="activates" data-drink="{{ $drink->id }}"></a>
                                <a href="changeDisplayName">{{ $drink->name }}</a>
                            </td>
                            <td>
                                <a href="#" class="activates" data-drink="{{ $drink->id }}" data-size="xs"></a>
                                <a href="changePrice">{{ current_user()->coffee_shop->priceFor($drink, 'xs') }}</a>
                            </td>
                            <td>
                                <a href="#" class="activates" data-drink="{{ $drink->id }}" data-size="sm"></a>
                                <a href="changePrice">{{ current_user()->coffee_shop->priceFor($drink, 'sm') }}</a>
                            </td>
                            <td>
                                <a href="#" class="activates" data-drink="{{ $drink->id }}" data-size="md"></a>
                                <a href="changePrice">{{ current_user()->coffee_shop->priceFor($drink, 'md') }}</a>
                            </td>
                            <td>
                                <a href="#" class="activates" data-drink="{{ $drink->id }}" data-size="lg"></a>
                                <a href="changePrice">{{ current_user()->coffee_shop->priceFor($drink, 'lg') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="food">

            </div>
        </div>
    </div>
@stop
