<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAboutToCoffeeShops extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coffee_shops', function (Blueprint $table) {
            $table->text('about');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coffee_shops', function (Blueprint $table) {
            $table->dropColumn('about');
        });
    }

}
