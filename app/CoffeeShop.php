<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Koolbeans\CoffeeShop
 *
 * @property integer $id 
 * @property integer $user_id 
 * @property string $name 
 * @property string $postal_code 
 * @property string $location 
 * @property float $latitude 
 * @property float $longitude 
 * @property integer $featured 
 * @property string $status 
 * @property string $comment 
 * @property string $place_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $phone_number 
 * @property-read \Koolbeans\User $user 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Koolbeans\GalleryImage[] $gallery 
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop wherePostalCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereFeatured($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop wherePlaceId($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\CoffeeShop wherePhoneNumber($value)
 * @method static \Koolbeans\CoffeeShop published()
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
     * @param \Illuminate\Database\Eloquent\Builder|\Koolbeans\CoffeeShop $query
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
}
