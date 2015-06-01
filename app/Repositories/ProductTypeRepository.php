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

    /**
     * @param string[] $types
     * @param string   $type
     *
     * @return bool
     */
    public function check($types, $type);

    /**
     * @param string $name
     *
     * @return \Koolbeans\ProductType
     */
    public function findByName($name);
}
