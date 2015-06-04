<?php namespace Koolbeans\Repositories;

use Illuminate\Http\Request;

interface ProductRepository
{
    /**
     * @param bool $withDisabled
     *
     * @return \Koolbeans\Product[]
     */
    public function food($withDisabled = false);

    /**
     * @param bool $withDisabled
     *
     * @return \Koolbeans\Product[]
     */
    public function drinks($withDisabled = false);

    /**
     * @return \Koolbeans\Product
     */
    public function newInstance();

    /**
     * @param \Illuminate\Http\Request $input
     *
     * @return \Koolbeans\Product
     */
    public function create(Request $input);

    /**
     * @param int $id
     *
     * @return \Koolbeans\Product
     */
    public function disable($id);

    /**
     * @param int $id
     *
     * @return \Koolbeans\Product
     */
    public function enable($id);

    /**
     * @param int $id
     *
     * @return \Koolbeans\Product
     */
    public function find($id);

    /**
     * @param int                      $id
     * @param \Illuminate\Http\Request $input
     *
     * @return \Koolbeans\Product
     */
    public function update($id, Request $input);

    /**
     * @return \Koolbeans\Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all();
}
