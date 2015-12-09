@extends('app')

@section('page-title')
    How it works
@stop

@section('content')
    <div id="about" class="main-content-padded">
        <!-- ORIGINAL VERSION (editable)
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
                    
                </p>
            </div>
        </div>
        -->
        <div class="about_sctn about_intro">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                        <h3> KoolBeans is the simple way to get great coffee on the go. </h3>
                        <p>Whether you are commuting to work, on your way to a lecture, sitting at your desk or in a town you don’t know, KoolBeans gives you an easy way to find, order and collect from the finest coffee shops on offer. The best news is, it’s free to use. <br/><br/> There are no extra fees or hidden charges for using KoolBeans so you can use it everyday to save you time and money.</p>
                    </div>
                </div>
            </div>  
        </div>
        <div class="about_sctn ab_s1">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                        <h2> <span>01.</span>Search </h2>
                        <p>Search for the town, city or street name of where you are looking for coffee and KoolBeans will show you the closest independent or small chain coffee shops to choose from.</p>
                        </div>
                </div>
            </div>  
        </div>
        <div class="about_sctn ab_s2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                        <h2> <span>02.</span>Browse </h2>
                        <p>Choose a coffee shop from the list and use the filter to find coffee shops by their amenities or even the atmosphere. Click ‘order coffee’ if you know what you want or ‘view profile’ to see more information..</p>
                        </div>
                </div>
            </div>  
        </div>
        <div class="about_sctn ab_s3">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                        <h2> <span>03.</span>Choose </h2>
                        <p>Each coffee shop has its own page where you can read a short description about them and also view the menu, see all the shops amenities, opening hours, reviews and even place an order.</p>
                        </div>
                </div>
            </div>  
        </div>
         <div class="about_sctn ab_s4">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                        <h2> <span>04.</span>Order </h2>
                        <p>Create your order, set a collection time or tick to ‘make on arrival’ if you’re not sure when you will arrive. Click the ’Place Order’ and use our secure checkout to pay online and collect in store.</p>
                       </div>
                </div>
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
