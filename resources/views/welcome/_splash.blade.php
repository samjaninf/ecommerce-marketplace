<div id="splash">
    <div id="splash-contents" class="container-fluid">
        <h1>Order great coffee,<br>from great coffee shops</h1>

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

                    <input class="btn btn-primary btn-lg" type="submit" value="Search">
                </div>
            </div>
        </form>
    </div>
</div>
