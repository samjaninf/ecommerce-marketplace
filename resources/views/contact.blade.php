@extends('app')

@section('page-title')
    Contact us
@stop

@section('content')
    <div class="container main-content-padded">

        <div class="row">
            <div class="col-xs-12">
                <h1>@yield('page-title')</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <form action="{{ url('contact') }}" class="form-horizontal" method="post">
                    <div class="form-group @if($errors->any()) {{$errors->has('name') ? 'has-error' : 'has-success'}} @endif">
                        <label for="name" class="col-sm-2 control-label">Your name:</label>

                        <div class="col-sm-10 col-md-6">
                            <input id="name"
                                   name="name"
                                   type="text"
                                   placeholder="Your name"
                                   class="form-control"
                                   value="{{old('name', current_user()->name)}}">
                        </div>
                    </div>

                    <div class="form-group @if($errors->any()) {{$errors->has('email') ? 'has-error' : 'has-success'}} @endif">
                        <label for="email" class="col-sm-2 control-label">Your email:</label>

                        <div class="col-sm-10 col-md-6">
                            <input id="email"
                                   name="email"
                                   type="email"
                                   placeholder="Your email..."
                                   class="form-control"
                                   value="{{old('email', current_user()->email)}}">
                        </div>
                    </div>

                    <div class="form-group @if($errors->any()) {{$errors->has('message') ? 'has-error' : 'has-success'}} @endif">
                        <label for="message" class="col-sm-2 control-label">Message:</label>
                        <div class="col-sm-10 col-md-6">
                            <textarea id="message" name="message" placeholder="Message..." class="form-control">{{old('message')}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-primary" value="Send!">
                        </div>
                    </div>

                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                </form>
            </div>
        </div>

    </div>
@stop
