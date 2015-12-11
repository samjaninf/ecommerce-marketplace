<div class="pull-left">
    @if ($shops->total() > 0)
       <h6> Showing {{ $shops->firstItem() }} - {{ $shops->lastItem() }} of {{ $shops->total() }} shops near{{ empty($query) ? 'by' : ' '.$query }}</h6> 
    @endif
</div>
<div class="form-inline pull-right">
    <div class="btn-group">

        <form id="search_update" method="post" action="{{ route('search') }}">
            <a href="#" class="btn btn-default filter-toggle">
                Filter... <span class="caret"></span>
            </a>
            <div class="dropdown-toggle" style="
                padding: 15px; 
                margin-top: 0; 
                min-width: 400px;    
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 1000;
                display: none;
                float: left;
                min-width: 160px;
                padding: 15px;
                margin: 2px 0 0;
                list-style: none;
                font-size: 14px;
                text-align: left;
                background-color: #fff;
                border: 1px solid #ccc;
                border: 1px solid rgba(0, 0, 0, 0.15);
                border-radius: 4px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
                background-clip: padding-box;
                min-width: 400px;">

               <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <b>Styles</b><br>
                        @foreach(\Koolbeans\CoffeeShop::getSpecs('attributes') as $spec)
                            <div class="checkbox search-filter-cb">
                                <label>
                                    <input name="f[{{$spec}}]"
                                           type="checkbox">{{ ucwords(str_replace('_', ' ', $spec)) }}
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
                                           type="checkbox">{{ ucwords(str_replace('_', ' ', $spec)) }}
                                </label>
                            </div><br class="hidden-xs">
                        @endforeach   

                    </div>
                    <div class="col-xs-12">
                        <a href="#" class="dropdown-close btn btn-primary text-right">Close</a>
                    </div>
                </div>
            </div>
            <input type="hidden" value="{{ $query }}" name="query"/>
            <input type="hidden" name="location" id="filter-location"/>
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>
            <input type="submit" value="Filter Results"/>
        </form>
    </div>
</div>
<div class="clearfix"></div>
