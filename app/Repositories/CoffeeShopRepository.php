<?php namespace Koolbeans\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface CoffeeShopRepository
{
    /**
     * Get all featured coffee shops.
     *
     * @return \Koolbeans\CoffeeShop[]|Collection
     */
    public function getFeatured();

    /**
     * Get all applications.
     *
     * @return \Koolbeans\CoffeeShop[]|Collection
     */
    public function getApplications();

    /**
     * Create a new instance of the model.
     *
     * @param array $attributes
     * @param bool  $exists
     *
     * @return \Koolbeans\CoffeeShop
     */
    public function newInstance($attributes = [], $exists = false);

    /**
     * Get most profitable coffee shops.
     *
     * @return \Koolbeans\CoffeeShop[]|Collection
     */
    public function getMostProfitable();

    /**
     * Find a coffee shop from its id.
     *
     * @param int $id
     *
     * @return \Koolbeans\CoffeeShop
     */
    public function find($id);

    /**
     * Get adjacent applications.
     *
     * @param \Koolbeans\CoffeeShop $coffeeShop
     *
     * @return \Koolbeans\CoffeeShop
     */
    public function findAdjacentApplications($coffeeShop);

    /**
     * Get next application.
     *
     * @param \Koolbeans\CoffeeShop $coffeeShop
     *
     * @return \Koolbeans\CoffeeShop
     */
    public function findNextApplication($coffeeShop);

    /**
     * Get previous application.
     *
     * @param \Koolbeans\CoffeeShop $coffeeShop
     *
     * @return \Koolbeans\CoffeeShop
     */
    public function findPreviousApplication($coffeeShop);

    /**
     * Proxy to model pagination
     *
     * @param integer $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage);

    /**
     * @return \Koolbeans\CoffeeShop[]
     */
    public function featurable();
}
