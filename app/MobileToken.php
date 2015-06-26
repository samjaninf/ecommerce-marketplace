<?php

namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

class MobileToken extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
