@extends('app')

@section('page-title')
    News list
@stop

@section('content')
    <div style="background-color: #f3f3f1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1>
                        @yield('page-title')
                    </h1>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    @foreach($posts as $post)
                        @include('posts._small')
                    @endforeach
                </div>

                {!! $posts->render() !!}
            </div>
        </div>
    </div>
@stop
