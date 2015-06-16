<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSpecsToCoffeeShops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coffee_shops', function (Blueprint $table) {
            $table->boolean('spec_independent')->default(false);
            $table->boolean('spec_food_available')->default(false);
            $table->boolean('spec_dog_friendly')->default(false);
            $table->boolean('spec_free_wifi')->default(false);
            $table->boolean('spec_geek_friendly')->default(false);
            $table->boolean('spec_meeting_friendly')->default(false);
            $table->boolean('spec_charging_ports')->default(false);
            $table->text('opening_times');
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
            $table->dropColumn([
                'spec_independent',
                'spec_food_available',
                'spec_dog_friendly',
                'spec_free_wifi',
                'spec_geek_friendly',
                'spec_meeting_friendly',
                'spec_charging_ports',
                'opening_times',
            ]);
        });
    }
}
