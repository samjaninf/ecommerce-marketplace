<?php namespace Koolbeans\Repositories;

use Koolbeans\CoffeeShop;

interface CoffeeShopRepository
{
    /**
     * @return CoffeeShop[]
     */
    public function getFeatured();

    /**
     * @param array $attributes
     * @param bool  $exists
     *
     * @return CoffeeShop
     */
    public function newInstance($attributes = [], $exists = false);
}
