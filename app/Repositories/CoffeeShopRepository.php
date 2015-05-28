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

    /**
     * Find a coffee shop from its id.
     *
     * @param int $id
     *
     * @return CoffeeShop
     */
    public function find($id);

    /**
     * Get adjacent applications.
     *
     * @param CoffeeShop $coffeeShop
     *
     * @return CoffeeShop
     */
    public function findAdjacentApplications($coffeeShop);

    /**
     * Get next application.
     *
     * @param CoffeeShop $coffeeShop
     *
     * @return CoffeeShop
     */
    public function findNextApplication($coffeeShop);

    /**
     * Get previous application.
     *
     * @param CoffeeShop $coffeeShop
     *
     * @return CoffeeShop
     */
    public function findPreviousApplication($coffeeShop);
}
