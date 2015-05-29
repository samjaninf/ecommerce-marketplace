<?php namespace Koolbeans;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

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
     * @var array
     */
    protected $attributes = [
        'role' => 'customer',
    ];

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
     * @return bool
     */
    public function hasValidCoffeeShop()
    {
        return $this->isOwner() && $this->coffee_shop->isValid();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('Koolbeans\Transaction');
    }
}
