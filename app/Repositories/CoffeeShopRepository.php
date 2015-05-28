<?php namespace Koolbeans\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Koolbeans\CoffeeShop;

interface CoffeeShopRepository
{
    /**
     * Get all featured coffee shops.
     *
     * @return CoffeeShop[]|Collection
     */
    public function getFeatured();

    /**
     * Get all applications.
     *
     * @return CoffeeShop[]|Collection
     */
    public function getApplications();

    /**
     * Create a new instance of the model.
     *
     * @param array $attributes
     * @param bool  $exists
     *
     * @return CoffeeShop
     */
    public function newInstance($attributes = [], $exists = false);

    /**
     * Get most profitable coffee shops.
     *
     * @return CoffeeShop[]|Collection
     */
    public function getMostProfitable();
}
