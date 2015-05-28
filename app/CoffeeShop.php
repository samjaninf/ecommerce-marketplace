<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

/**
 * Koolbeans\CoffeeShop
 *
 * @property-read \Koolbeans\User $user
 * @property integer              $id
 * @property integer              $user_id
 * @property string               $name
 * @property string               $location
 * @property float                $latitude
 * @property float                $longitude
 * @property int                  $featured
 * @property string               $status
 * @property string               $comment
 * @property string               $place_id
 * @property \Carbon\Carbon       $created_at
 * @property \Carbon\Carbon       $updated_at
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereUserId( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereName( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereLocation( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereLatitude( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereLongitude( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereFeatured( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereStatus( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereComment( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop wherePlaceId( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop whereUpdatedAt( $value )
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
}
