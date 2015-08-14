<form action="{{ route('coffee-shop.offer-update', $coffeeShop->id) }}" method="post">
    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
    <div class="row">
        <div class="col-xs-12 col-sm-1">
            <label for="offer_activated" style="margin-top: 40px">
                <input id="offer_activated"
                       name="offer_activated"
                       class="activates "
                       type="checkbox"
                       value="on"
                       @if($coffeeShop->offer_activated) checked @endif>
            </label>
        </div>
        <div class="col-xs-12 col-sm-9">
            <h2>Activate Offers for Your Shop</h2>
            <hr>

            <h3>'Buy 1 Get 1 Half Price</h3>
            <div class="form-group">
                <label for="offer_drink_only">
                    Choose what items this offer applies to
                </label>
                <select class="form-control" name="offer_drink_only" id="offer_drink_only">
                    <option value="drinks_only">Offer applies to drinks only</option>
                    <option value="drinks_food">Offer applies to drinks and food</option>
                </select>
            </div>

            <div class="form-group">
                <label for="offer_times">
                    Choose what times of the day the offer operates
                </label>
                <select class="form-control" name="offer_times" id="offer_times">
                    <option value="off-peak">Off-Peak times, excluded weekends (recommended)</option>
                    <option value="off-peak-weekends">Off-Peak times, including weekends</option>
                    <option value="all">All day, including weekends</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-2">
            <button type="submit" class="btn btn-primary form-control" style="margin-top: 30px">Save</button>
        </div>
    </div>
</form>
