<?php namespace Koolbeans;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

/**
 * Koolbeans\User
 *
 * @property-read \Koolbeans\CoffeeShop $coffee_shop
 * @property integer                    $id
 * @property string                     $name
 * @property string                     $email
 * @property string                     $password
 * @property string                     $remember_token
 * @property \Carbon\Carbon             $created_at
 * @property \Carbon\Carbon             $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\User whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\User whereName( $value )
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\User whereEmail( $value )
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\User wherePassword( $value )
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\User whereRememberToken( $value )
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\User whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\Koolbeans\User whereUpdatedAt( $value )
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract, BillableContract
{

    use Authenticatable, CanResetPassword, Billable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function coffee_shop()
    {
        return $this->hasOne('Koolbeans\CoffeeShop');
    }

    /**
     * @return bool
     */
    public function isOwner()
    {
        return $this->coffee_shop !== null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('Koolbeans\Transaction');
    }
}
