<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['coffee_shop_id', 'product_id', 'finish_at'];

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
