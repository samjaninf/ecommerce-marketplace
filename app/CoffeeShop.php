<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

/**
 * Koolbeans\CoffeeShop
 *
 * @property-read \Koolbeans\User $user
 * @property int                  featured
 */
class CoffeeShop extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Koolbeans\User');
    }
}
