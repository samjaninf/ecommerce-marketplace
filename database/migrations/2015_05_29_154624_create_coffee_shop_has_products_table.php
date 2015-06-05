<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoffeeShopHasProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffee_shop_has_products', function (Blueprint $table) {
            $table->integer('coffee_shop_id')->unsigned();
            $table->foreign('coffee_shop_id')->references('id')->on('coffee_shops');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('name');
            $table->boolean('activated')->default(true);
            $table->boolean('xs_activated')->default(false);
            $table->boolean('sm_activated')->default(false);
            $table->boolean('md_activated')->default(false);
            $table->boolean('lg_activated')->default(false);
            $table->integer('xs')->unsigned();
            $table->integer('sm')->unsigned();
            $table->integer('md')->unsigned();
            $table->integer('lg')->unsigned();
            $table->primary(['coffee_shop_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coffee_shop_has_products');
    }

}
