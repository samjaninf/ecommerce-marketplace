<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Koolbeans\Product
 *
 * @property integer $id 
 * @property string $type 
 * @property string $name 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Koolbeans\ProductType[] $types 
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Product whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Product whereDeletedAt($value)
 */
class Product extends Model
{

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name', 'type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function types()
    {
        return $this->belongsToMany('Koolbeans\ProductType', 'product_has_types');
    }

    /**
     * @param null|string $glue
     *
     * @return array|string
     */
    public function getTypesName($glue = null)
    {
        $names = [];

        foreach ($this->types as $type) {
            $names[] = $type->name;
        }

        return $glue === null ? $names : implode($glue, $names);
    }

}
