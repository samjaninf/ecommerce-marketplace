<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
