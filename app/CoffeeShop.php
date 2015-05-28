<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Koolbeans\CoffeeShop
 *
 * @property integer              $id
 * @property integer              $user_id
 * @property string               $name
 * @property string               $postal_code
 * @property string               $location
 * @property float                $latitude
 * @property float                $longitude
 * @property integer              $featured
 * @property string               $status
 * @property string               $comment
 * @property string               $place_id¶
 * @property \Carbon\Carbon       $created_at
 * @property \Carbon\Carbon       $updated_at
 * @property-read \Koolbeans\User $user
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereUserId( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereName( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop wherePostalCode( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereLocation( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereLatitude( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereLongitude( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereFeatured( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereStatus( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereComment( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop wherePlaceId( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop published()
 */
class CoffeeShop extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name', 'location', 'latitude', 'longitude', 'comment', 'postal_code', 'place_id'];

    /**
     * @var array
     */
    protected $attributes = [
        'status'   => 'requested',
        'featured' => -1,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Koolbeans\User');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Koolbeans\CoffeeShop $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->whereStatus('published');
    }
}
