<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDisplayNamesForSizesToCoffeeshops extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coffee_shops', function (Blueprint $table) {
            $table->string('display_xs')->default('Small');
            $table->string('display_sm')->default('Medium');
            $table->string('display_md')->default('Large');
            $table->string('display_lg')->default('Extra-Large');
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
            $table->dropColumn(['display_xs', 'display_sm', 'display_md', 'display_lg']);
        });
    }

}
