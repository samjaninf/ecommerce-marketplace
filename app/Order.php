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
    public function user()
    {
        return $this->belongsTo('Koolbeans\User');
    }

}
