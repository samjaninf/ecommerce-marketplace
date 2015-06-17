<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_lines()
    {
        return $this->hasMany('Koolbeans\OrderLine');
    }

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
    public function user()
    {
        return $this->belongsTo('Koolbeans\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * @return string
     */
    public function getNextStatus()
    {
        if ($this->status == 'waiting') {
            return 'preparing';
        }

        if ($this->status == 'preparing') {
            return 'ready';
        }

        return 'collected';
    }

}
