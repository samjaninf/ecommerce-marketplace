<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('Koolbeans\Product');
    }
}
