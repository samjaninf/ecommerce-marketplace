@extends('app')

@section('page-title')
    Add a post
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    @yield('page-title')
                    <span id="page-actions">
                        <a href="{{ route('admin.home') }}" class="btn btn-primary">
                            Dashboard
                        </a>
                    </span>
                </h1>
            </div>
        </div>
        <form action="{{ route('admin.post.store') }}" class="form-horizontal" method="post">
            @include('admin.posts._form')
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-success" value="Add a post">
                </div>
            </div>
        </form>
    </div>
@endsection
