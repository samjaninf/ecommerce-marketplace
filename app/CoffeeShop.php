<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Koolbeans\CoffeeShop
 *
 * @property integer                                                                 $id
 * @property integer                                                                 $user_id
 * @property string                                                                  $name
 * @property string                                                                  $postal_code
 * @property string                                                                  $location
 * @property float                                                                   $latitude
 * @property float                                                                   $longitude
 * @property integer                                                                 $featured
 * @property string                                                                  $status
 * @property string                                                                  $comment
 * @property string                                                                  $place_id
 * @property \Carbon\Carbon                                                          $created_at
 * @property \Carbon\Carbon                                                          $updated_at
 * @property string                                                                  $phone_number
 * @property-read \Koolbeans\User                                                    $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\Koolbeans\GalleryImage[] $gallery
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
 * @method static \Illuminate\Database\Query\Builder|CoffeeShop wherePhoneNumber( $value )
 * @method static CoffeeShop published()
 */
class CoffeeShop extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'comment',
        'phone_number',
        'postal_code',
        'place_id',
    ];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gallery()
    {
        return $this->hasMany('Koolbeans\GalleryImage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews()
    {
        return $this->belongsToMany('Koolbeans\User', 'coffee_shop_has_reviews')
                    ->withPivot('review', 'rating', 'created_at');
    }

    /**
     * @return int
     */
    public function getRating()
    {
        static $rating = -1;

        if ($rating === -1) {
            $rating = $this->getConnection()
                           ->table($this->reviews()->getTable())
                           ->where('coffee_shop_id', '=', $this->id)
                           ->avg('rating');
        }

        return round($rating);
    }

    /**
     * @return static|null
     */
    public function getBestReview()
    {
        return $this->reviews()->orderBy('rating', 'desc')->first();
    }

    /**
     * Whether a shop has been accepted or not.
     *
     * @return bool
     */
    public function isValid()
    {
        return in_array($this->status, ['published', 'accepted']);
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->status === 'published';
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|CoffeeShop $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->whereStatus('published');
    }

    /**
     * @return string
     */
    public function getUploadPath()
    {
        return public_path($this->getUploadUrl());
    }

    /**
     * @return string
     */
    public function getUploadUrl()
    {
        return '/uploads/' . $this->getUniqueUploadKey();
    }

    /**
     * @return string
     */
    private function getUniqueUploadKey()
    {
        return sha1(( (string) $this->id ) . \Config::get('app.key'));
    }

    /**
     * @return null
     */
    public function mainImage()
    {
        $image = $this->gallery->first();

        return $image === null ? ( '/img/shared/default.png' ) : ( $this->getUploadUrl() . '/' . $image->image );
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->latitude . ',' . $this->longitude;
    }

    /**
     * @param string $contents
     * @param int    $rating
     */
    public function addReview($contents, $rating)
    {
        $review                 = new Review();
        $review->review         = $contents;
        $review->rating         = $rating;
        $review->user_id        = current_user()->id;
        $review->coffee_shop_id = $this->id;

        $review->save();
    }

    /**
     * @param \Koolbeans\Product $product
     * @param string             $size
     *
     * @return int
     */
    public function priceFor(Product $product, $size = null)
    {
        $sizes = $this->products()->find($product->id);

        if ($sizes === null) {
            return '#';
        }

        $price = $sizes->pivot->$size;

        if ($price === -1) {
            return '#';
        }

        return '£ ' . $price / 100.;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('Koolbeans\Product', 'coffee_shop_has_products')
                    ->withPivot('name', 'xs', 'sm', 'md', 'lg');
    }
}
