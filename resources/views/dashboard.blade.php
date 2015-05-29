@extends('app')

@section('page-title')
    Your coffee shop
@endsection

@section('content')
    <div class="container-fluid">
        @include('dashboard._header')
        <div class="row">
            <div class="col-sm-3">
                <h3>
                    Seller dashboard

                    <button type="button" class="btn btn-default btn-sm hide visible-xs-inline" data-toggle="collapse"
                            data-target="#dashboard-menu">
                        Expand
                    </button>
                </h3>
                <div class="list-group collapse navbar-collapse" id="dashboard-menu">
                    <a href="#" class="list-group-item">Your account</a>
                    <a href="#" class="list-group-item">Menu</a>
                    <a href="#" class="list-group-item">Reporting</a>
                    <a href="#" class="list-group-item">Order history</a>
                    <hr class="hidden-xs">
                    <a href="#" class="list-group-item">Support</a>
                    <a href="#" class="list-group-item">Contact us</a>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-xs-12">
                        <h2>Current orders</h2>
                    </div>
                    <div class="col-xs-12">
                        <h2>Most bought products</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
