@extends('app')

@section('content')
<div class="container-fluid" style="background-color: #f3f3f3">
    <div class="row main-content-padded">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="text-center">Welcome to Koolbeans!</h1>

            <p class="text-center">30 Seconds to register to start finding great coffee, from great coffee shops.
            </p>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label class="col-md-3 control-label">Name</label>

                    <div class="col-md-7">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">E-Mail Address</label>

                    <div class="col-md-7">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Password</label>

                    <div class="col-md-7">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Confirm Password</label>

                    <div class="col-md-7">
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7 col-md-offset-3">
                        <button type="submit" class="btn btn-primary" style="padding: 10px 40px; font-size: 24pt;">
                            Join us
                        </button>

                        <a href="{{ route('coffee-shop.apply') }}" class="btn btn-success pull-right">Are you a coffee shop?</a><br><br>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
