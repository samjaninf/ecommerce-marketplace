<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOffersBits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coffee_shops', function (Blueprint $table) {
            $table->boolean('offer_activated');
            $table->boolean('offer_drink_only');
            $table->enum('offer_times', ['off-peak', 'off-peak-weekends', 'all']);
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
            $table->dropColumn(['offer_activated', 'offer_drink_only', 'offer_times']);
        });
    }
}
