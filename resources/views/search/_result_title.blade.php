<h6>Showing coffee shops near{{ empty($query) ? 'by' : '' }}...</h6>
<h2>{{ $query }}</h2>

<form class="form-inline" method="post">
    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
    <div class="form-group">
        <label class="sr-only" for="search">Search</label>
        <input type="text"
               class="form-control"
               id="Search"
               placeholder="Enter a new location"
               name="query">
    </div>

    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filter... <span class="caret"></span>
        </button>
        <div class="dropdown-menu" style="padding: 15px; margin-top: 0; min-width: 400px">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <b>Attributes</b><br>
                    @foreach(\Koolbeans\CoffeeShop::getSpecs('attributes') as $spec)
                        <div class="checkbox">
                            <label>
                                <input name="f[{{$spec}}]"
                                       type="checkbox"
                                       class="search-filter"
                                       @if(in_array($spec, $filters)) checked @endif> {{ ucwords(str_replace('_', ' ', $spec)) }}
                            </label>
                        </div><br class="hidden-xs">
                    @endforeach
                </div>
                <div class="col-xs-12 col-sm-6">
                    <b>Ammenties</b><br>
                    @foreach(\Koolbeans\CoffeeShop::getSpecs('ammenties') as $spec)
                        <div class="checkbox">
                            <label>
                                <input name="f[{{$spec}}]"
                                       type="checkbox"
                                       class="search-filter"
                                       @if(in_array($spec, $filters)) checked @endif> {{ ucwords(str_replace('_', ' ', $spec)) }}
                            </label>
                        </div><br class="hidden-xs">
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-default btn-primary">Search</button>
</form>
