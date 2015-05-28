<?php namespace Koolbeans\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Koolbeans\CoffeeShop;

class EloquentCoffeeShopRepository implements CoffeeShopRepository
{

    /**
     * @var \Koolbeans\CoffeeShop|Builder
     */
    private $model;

    /**
     * @param \Koolbeans\CoffeeShop $model
     */
    public function __construct(CoffeeShop $model)
    {
        $this->model = $model;
    }

    /**
     * Get all featured coffee shops.
     *
     * @return CoffeeShop[]|Collection
     */
    public function getFeatured()
    {
        return $this->model->published()->where('featured', '>', 0)->orderBy('featured', 'asc')->get();
    }

    /**
     * Get all applications.
     *
     * @return CoffeeShop[]|Collection
     */
    public function getApplications()
    {
        return $this->model->where('status', 'requested')->orderBy('created_at', 'dec')->get();
    }

    /**
     * Create a new instance of the model.
     *
     * @param array $attributes
     * @param bool  $exists
     *
     * @return CoffeeShop
     */
    public function newInstance($attributes = [], $exists = false)
    {
        return $this->model->newInstance($attributes, $exists);
    }

    /**
     * Get most profitable coffee shops.
     *
     * @return CoffeeShop[]|Collection
     */
    public function getMostProfitable()
    {
        return $this->model->published()->limit(5)->get();
    }
}
