<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

class OfferDetail extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('Koolbeans\Offer');
    }

    /**
     * @return string
     */
    public function getTypeDisplay()
    {
        if ($this->type == 'free') {
            return 'Free';
        }

        if ($this->type == 'flat') {
            return 'Flat reduction';
        }

        return 'Percentage reduction';
    }

}
