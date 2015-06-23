<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOpeningTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_times', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day_of_week');
            $table->time('start_hour');
            $table->time('stop_hour');
            $table->boolean('active')->default(false);
            $table->integer('coffee_shop_id')->unsigned();
            $table->foreign('coffee_shop_id')->references('id')->on('coffee_shops');
        });

        Schema::table('coffee_shops', function (Blueprint $table) {
            $table->dropColumn('opening_times');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('opening_times');
        Schema::table('coffee_shops', function (Blueprint $table) {
            $table->text('opening_times');
        });
    }
}
