<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coffee_shop()
    {
        return $this->belongsTo('Koolbeans\CoffeeShop');
    }
}
