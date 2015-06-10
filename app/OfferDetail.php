<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

class OfferDetail extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['type', 'product_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function offer()
    {
        return $this->belongsTo('Koolbeans\Offer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('Koolbeans\Product');
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

    public function amount($size)
    {
        if ($this->type === 'percentage') {
            return $this->{'amount_' . $size} . '%';
        }

        return '£ ' . $this->{'amount_' . $size} / 100.;
    }
}
