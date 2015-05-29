<?php namespace Koolbeans\Repositories;

interface ProductTypeRepository
{
    /**
     * @param string $name
     * @param string $type
     *
     * @return \Koolbeans\ProductType
     */
    public function create($name, $type);

    /**
     * @return \Koolbeans\ProductType[]
     */
    public function drinks();

    /**
     * @return \Koolbeans\ProductType[]
     */
    public function food();
}
