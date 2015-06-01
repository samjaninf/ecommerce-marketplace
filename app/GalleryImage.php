<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

/**
 * Koolbeans\GalleryImage
 *
 * @property integer $id 
 * @property string $image 
 * @property integer $position 
 * @property integer $width 
 * @property integer $height 
 * @property integer $coffee_shop_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Koolbeans\CoffeeShop $coffee_shop 
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\GalleryImage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\GalleryImage whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\GalleryImage wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\GalleryImage whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\GalleryImage whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\GalleryImage whereCoffeeShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\GalleryImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\GalleryImage whereUpdatedAt($value)
 */
class GalleryImage extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['image', 'position'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coffee_shop()
    {
        return $this->belongsTo('Koolbeans\CoffeeShop');
    }
}
