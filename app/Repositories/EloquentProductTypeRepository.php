<?php namespace Koolbeans\Repositories;

use Koolbeans\ProductType;

class EloquentProductTypeRepository implements ProductTypeRepository
{
    /**
     * @var \Koolbeans\ProductType
     */
    private $model;

    /**
     * @param \Koolbeans\ProductType $model
     */
    public function __construct(ProductType $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $name
     * @param string $type
     *
     * @return \Koolbeans\ProductType
     */
    public function create($name, $type)
    {
        return $this->model->create(['name' => $name, 'type' => $type]);
    }

    /**
     * @return \Koolbeans\ProductType[]
     */
    public function drinks()
    {
        return $this->model->whereType('drink')->get();
    }

    /**
     * @return \Koolbeans\ProductType[]
     */
    public function food()
    {
        return $this->model->whereType('food')->get();
    }

    /**
     * @param string[] $types
     * @param string   $type
     *
     * @return bool
     */
    public function check($types, $type)
    {
        return $this->model->whereType($type)->whereIn('name', $types)->count() === count($types);
    }

    /**
     * @param string $name
     *
     * @return \Koolbeans\ProductType
     */
    public function findByName($name)
    {
        return $this->model->whereName($name)->first();
    }
}
