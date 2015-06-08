<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;

/**
 * Koolbeans\Transaction
 *
 * @property integer $id 
 * @property integer $user_id 
 * @property integer $amount 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Koolbeans\User $user 
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Transaction whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Transaction whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\Transaction whereUpdatedAt($value)
 */
class Transaction extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['amount', 'charged', 'stripe_charge_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Koolbeans\User');
    }
}
