<?php namespace Koolbeans\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
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

    /**
     * Find a coffee shop from its id.
     *
     * @param int $id
     *
     * @return CoffeeShop
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Get adjacent applications.
     *
     * @param CoffeeShop $coffeeShop
     *
     * @return CoffeeShop[]
     */
    public function findAdjacentApplications($coffeeShop)
    {
        return [$this->findPreviousApplication($coffeeShop), $this->findNextApplication($coffeeShop)];
    }

    /**
     * Get next application.
     *
     * @param CoffeeShop $coffeeShop
     *
     * @return CoffeeShop
     */
    public function findNextApplication($coffeeShop)
    {
        return $this->model->whereStatus('requested')->where('id', '>', $coffeeShop->id)->orderBy('id', 'asc')->first();
    }

    /**
     * Get previous application.
     *
     * @param CoffeeShop $coffeeShop
     *
     * @return CoffeeShop
     */
    public function findPreviousApplication($coffeeShop)
    {
        return $this->model->whereStatus('requested')
                           ->where('id', '<', $coffeeShop->id)
                           ->orderBy('id', 'desc')
                           ->first();
    }

}
