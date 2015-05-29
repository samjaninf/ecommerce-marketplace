<?php namespace Koolbeans\Repositories;

interface ProductRepository
{
    /**
     * @return \Koolbeans\Product[]
     */
    public function food();

    /**
     * @return \Koolbeans\Product[]
     */
    public function drinks();

    /**
     * @return \Koolbeans\Product
     */
    public function newInstance();
}
