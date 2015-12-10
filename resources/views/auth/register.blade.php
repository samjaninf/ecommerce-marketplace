@extends('app')

@section('content')
<div class="container-fluid" style="background-color: #f3f3f3">
    <div class="row main-content-padded">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2 register-title">
                    <h1 class="text-center">Welcome to Koolbeans!</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2 register-form">
                    <p class="text-center" style="font-size: 17px;">30 Seconds to register to start finding great coffee, from great coffee shops.
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

                        <div class="form-group submit-register">
                     

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">
                                            Join us
                                        </button>
                                    </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
