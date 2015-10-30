<div class="pull-left">
    @if ($shops->total() > 0)
       <h6> Showing {{ $shops->firstItem() }} - {{ $shops->lastItem() }} of {{ $shops->total() }} shops near{{ empty($query) ? 'by' : ' '.$query }}</h6> 
    @endif
</div>
<div class="form-inline pull-right">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filter... <span class="caret"></span>
        </button>
        <div class="dropdown-menu" style="padding: 15px; margin-top: 0; min-width: 400px">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <b>Attributes</b><br>
                    @foreach(\Koolbeans\CoffeeShop::getSpecs('attributes') as $spec)
                        <div class="checkbox search-filter-cb">
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
</div>
<div class="clearfix"></div>
