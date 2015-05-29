<?php namespace Koolbeans\Repositories;

use Koolbeans\Product;

class EloquentProductRepository implements ProductRepository
{
    /**
     * @var \Koolbeans\Product
     */
    private $model;

    /**
     * @param \Koolbeans\Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Koolbeans\Product[]
     */
    public function food()
    {
        return $this->model->whereType('food')->get();
    }

    /**
     * @return \Koolbeans\Product[]
     */
    public function drinks()
    {
        return $this->model->whereType('drink')->get();
    }

    /**
     * @return \Koolbeans\Product
     */
    public function newInstance()
    {
        return $this->model->newInstance();
    }
}
