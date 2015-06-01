<?php

use Illuminate\Database\Migrations\Migration;

class RevertFeaturedToBoolean extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE coffee_shops CHANGE featured featured tinyint(1)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE coffee_shops CHANGE featured featured integer');
    }

}
