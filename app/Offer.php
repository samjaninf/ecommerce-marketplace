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
        return $this->belongsTo(CoffeeShop::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(OfferDetail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        $detail = $this->details()->first();
        if ($detail->type == 'free') {
            return 'FREE';
        }

        if ($detail->amount_xs) {
            $amount = $detail->amount_xs;
        } elseif ($detail->amount_sm) {
            $amount = $detail->amount_sm;
        } elseif ($detail->amount_sm) {
            $amount = $detail->amount_md;
        } else {
            $amount = $detail->amount_lg;
        }

        if ($this->type == 'flat') {
            return number_format($amount / 100, 2) . ' £';
        }

        return $amount . '%';
    }

    /**
     * @return Product
     */
    public function productOnDeal()
    {
        $detail = $this->details()->first();
        return $detail->product ? $detail->product : $this->product;
    }

}
