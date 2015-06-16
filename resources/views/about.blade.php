@extends('app')

@section('page-title')
    About us
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
                @if(! Auth::guest() && current_user()->role == 'admin')
                    <a href="#" id="edit-about-site">Edit text</a>
                    <form action="{{ url('about') }}" method="post" id="aboutForm" class="hide row form-horizontal">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                        <div class="form-group @if($errors->any()) {{$errors->has('about') ? 'has-error' : 'has-success'}} @endif">
                            <label for="about" class="col-sm-2 control-label">About:</label>

                            <div class="col-sm-10 col-md-6">
                                <textarea id="about"
                                          name="about"
                                          placeholder="About..."
                                          class="form-control">{{old('about', $about)}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary" value="Submit!">
                            </div>
                        </div>
                    </form>
                @endif
                <p>
                    {{ $about }}
                </p>
            </div>
        </div>

    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $('#edit-about-site').on('click', function (e) {
            $('#aboutForm').removeClass('hide');
            return koolbeans.cancelEvent(e);
        })
    </script>
@stop
