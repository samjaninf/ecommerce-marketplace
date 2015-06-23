<?php

namespace Koolbeans;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OpeningTime extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var bool
     */
    public $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coffee_shop()
    {
        return $this->belongsTo('Koolbeans\CoffeeShop');
    }

    /**
     * @param string $value
     *
     * @return \Carbon\Carbon
     */
    public function getStartHourAttribute($value)
    {
        return new Carbon($value);
    }

    /**
     * @param string $value
     *
     * @return \Carbon\Carbon
     */
    public function getStopHourAttribute($value)
    {
        return new Carbon($value);
    }
}
