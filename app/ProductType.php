<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

/**
 * Koolbeans\ProductType
 *
 * @property integer $id 
 * @property string $type 
 * @property string $name 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Koolbeans\Product[] $products 
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\ProductType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\ProductType whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\ProductType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\ProductType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\ProductType whereUpdatedAt($value)
 */
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

    /**
     * @param int $id
     *
     * @return bool
     */
    public function hasProduct($id)
    {
        foreach ($this->products as $product) {
            if ($product->id === $id) return true;
        }

        return false;
    }
}
