<div id="splash">
    @if ($agent->isMobile() || $agent->isTablet())
    <!-- Image -->
    @else
      <video loop="loop"  autoplay="autoplay" poster="/video/splash.jpg" title="KoolBeans">
        <source src="/video/splash.m4v" type="video/mp4" />
        <source src="/video/splash.webm" type="video/webm" />
      </video>
    @endif
    <div id="splash-contents" class="container-fluid text-center">
        <h1>Grab a coffee</h1>
        <h4>Order ahead from the best independent coffee shops</h4>
          @if (isset ($response) && $response != '')
            <div class="alert alert-success" style="display: inline-block; padding-top: 5px;"><h3>{{ $response }}</h3></div>
          @endif
        <form class="form-inline" action="{{route('search')}}" method="post">
            <div class="form-group @if($errors->any()) {{$errors->has('query') ? 'has-error' : 'has-success'}} @endif">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                <label for="query" class="sr-only">Query:</label>

                <div class="input-group">
                    <input id="query"
                           name="query"
                           type="text"
                           placeholder="Enter your location to find a shop..."
                           class="form-control input-lg"
                           value="{{old('query')}}">
                    <input type="hidden" name="location" id="my-current-location">

                    <input class="btn btn-primary btn-lg" type="submit" value="Search">
                </div>
            </div>
        </form>
    </div>
</div>
