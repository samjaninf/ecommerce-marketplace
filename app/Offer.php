<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coffee_shop()
    {
        return $this->belongsTo('Koolbeans\CoffeeShop');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('Koolbeans\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany('Koolbeans\OfferDetail');
    }

}
