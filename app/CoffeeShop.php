<?php namespace Koolbeans;

use Carbon\Carbon;
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
        'county',
        'spec_independent',
        'spec_food_available',
        'spec_dog_friendly',
        'spec_free_wifi',
        'spec_geek_friendly',
        'spec_meeting_friendly',
        'spec_charging_ports',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'status'   => 'requested',
        'featured' => -1,
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'status',
        'featured',
        'created_at',
        'updated_at',
        'user_id',
        'place_id',
        'id',
        'about',
        'comment',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('Koolbeans\Order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opening_times()
    {
        return $this->hasMany('Koolbeans\OpeningTime');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany('Koolbeans\Offer');
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
    public function getXeroName()
    {
        return $this->name . '_IID_' . $this->id;
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
        $price = $this->hasActivated($product, $size, true);

        return $price === false ? '£' : '£ ' . number_format($price / 100., 2);
    }

    /**
     * @param \Koolbeans\Product $product
     * @param string             $size
     * @param bool               $forceGetPrice
     *
     * @return bool|int
     */
    public function hasActivated(Product $product, $size = null, $forceGetPrice = false)
    {
        $sizes = $this->products()->find($product->id);

        if ($sizes === null || $sizes->pivot->activated == false) {
            return false;
        }

        if ($size === null) {
            return true;
        }

        $price = $sizes->pivot->$size;

        if ( ! $forceGetPrice && ( $price === -1 || $sizes->pivot->{$size . '_activated'} == false )) {
            return false;
        }

        return $price;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('Koolbeans\Product', 'coffee_shop_has_products')
                    ->withPivot('name', 'xs', 'sm', 'md', 'lg', 'activated', 'xs_activated', 'sm_activated',
                        'md_activated', 'lg_activated');
    }

    /**
     * @param $product
     * @param $size
     */
    public function toggleActivated($product, $size = null)
    {
        $p = $this->findProduct($product->id);

        if ($size === null) {
            $p->pivot->activated = ! $p->pivot->activated;
        } else {
            $p->pivot->{$size . '_activated'} = ! $p->pivot->{$size . '_activated'};
        }

        $p->pivot->save();
    }

    /**
     * @param $product
     *
     * @return mixed
     */
    public function getNameFor($product)
    {
        if ( ! is_object($product)) {
            dd($product);
        }
        $p = $this->products()->find($product->id);

        if ($p && $p->pivot->name) {
            return $p->pivot->name;
        }

        return $product->name;
    }

    /**
     * @param $productId
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findProduct($productId)
    {
        $p = $this->products()->find($productId);

        if ($p === null) {
            $this->products()->attach($productId);
            $p                   = $this->products()->find($productId);
            $p->pivot->activated = false;
        }

        return $p;
    }

    /**
     * @param string $size
     *
     * @return string
     */
    public function getSizeDisplayName($size)
    {
        return $this->{'display_' . $size};
    }

    public function showOpeningTimes()
    {
        $openingTimes = $this->opening_times()->whereActive(true)->get();

        if ($openingTimes->count() > 0) {
            $times = [];
            foreach ($openingTimes as $openingTime) {
                $found = false;

                foreach ($times as $i => $time) {
                    if ($openingTime->start_hour->eq($time['start']) && $openingTime->stop_hour->eq($time['end'])) {
                        $times[ $i ]['days'][] = $openingTime->day_of_week;
                        $found                 = true;
                        break;
                    }
                }

                if ( ! $found) {
                    $times[] = [
                        'start' => $openingTime->start_hour,
                        'end'   => $openingTime->stop_hour,
                        'days'  => [$openingTime->day_of_week],
                    ];
                }
            }

            return implode("\n", array_map(function ($time) {
                $days = $this->formatDays($time['days']);

                return $days . " " . $time['start']->format("H:i") . "-" . $time['end']->format("H:i");
            }, $times));
        }

        return "No opening time has been set.";
    }

    /**
     * @param string $day
     *
     * @return bool
     */
    public function isOpenOn($day)
    {
        return $this->opening_times()->whereDayOfWeek(mb_substr($day, 0, 3))->whereActive(true)->count() > 0;
    }

    /**
     * @param string $day
     *
     * @return string
     */
    public function getStartingHour($day)
    {
        $ins = $this->opening_times()
                    ->whereDayOfWeek(mb_substr($day, 0, 3))
                    ->first();

        if ($ins === null) {
            return '08:00';
        }

        return $ins->start_hour->format('H:i');
    }

    /**
     * @param \Carbon\Carbon $time
     *
     * @return bool
     */
    public function isOpen(Carbon $time)
    {
        $opened = $this->opening_times()->whereDayOfWeek($time->format('D'))->first();

        return ($opened && $opened->start_hour->lte($time) && $opened->stop_hour->gte($time));
    }

    /**
     * @param string $day
     *
     * @return string
     */
    public function getStoppingHour($day)
    {
        $ins = $this->opening_times()
                    ->whereDayOfWeek(mb_substr($day, 0, 3))
                    ->first();

        if ($ins === null) {
            return '19:00';
        }

        return $ins->stop_hour->format('H:i');
    }

    /**
     * @param array $days
     */
    private function formatDays(array $days)
    {
        $list = [
            'Mon' => false,
            'Tue' => false,
            'Wed' => false,
            'Thu' => false,
            'Fri' => false,
            'Sat' => false,
            'Sun' => false,
        ];

        foreach ($list as $day => $v) {
            if (in_array(strtolower($day), $days)) {
                $list[ $day ] = true;
            }
        }

        $keep      = null;
        $previous  = null;
        $formatted = [];
        foreach ($list as $day => $active) {
            if ($keep) {
                if ( ! $active || $day === 'Sun') {
                    if ($day === 'Sun' && $active) {
                        $previous = $day;
                    }

                    if ($previous === $keep) {
                        $formatted[] = $keep;
                    } else {
                        $formatted[] = "$keep-$previous";
                    }

                    $keep = null;
                }
            } elseif ($active) {
                $keep = $day;
            }

            $previous = $day;
        }

        return implode(", ", $formatted);
    }
}
