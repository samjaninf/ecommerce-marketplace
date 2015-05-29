<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{

    /**
     * @var string
     */
    protected $table = 'product_types';

    /**
     * @var array
     */
    protected $fillable = ['name', 'type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('Koolbeans\Product', 'product_has_types');
    }
}
