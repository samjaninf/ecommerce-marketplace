<?php namespace Koolbeans\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Koolbeans\CoffeeShop;

class EloquentCoffeeShopRepository implements CoffeeShopRepository
{

    /**
     * @var \Koolbeans\CoffeeShop
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
     * @return Collection
     */
    public function getFeatured()
    {
        return $this->model->where('featured', '>', 0)->orderBy('featured', 'asc')->get();
    }
}
