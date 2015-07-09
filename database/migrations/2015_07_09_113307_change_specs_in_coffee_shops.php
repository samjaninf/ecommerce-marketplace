<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeSpecsInCoffeeShops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coffee_shops', function (Blueprint $table) {
            $table->dropColumn([
                'spec_independent',
                'spec_dog_friendly',
                'spec_geek_friendly',
            ]);

            $table->boolean('spec_techy')->default(false);
            $table->boolean('spec_student')->default(false);
            $table->boolean('spec_quiet')->default(false);
            $table->boolean('spec_relaxed')->default(false);
            $table->boolean('spec_urban')->default(false);
            $table->boolean('spec_alternative')->default(false);
            $table->boolean('spec_artisan')->default(false);
            $table->boolean('spec_payable_wifi')->default(false);
            $table->boolean('spec_dogs_welcome')->default(false);
            $table->boolean('spec_in_and_out_seating')->default(false);
            $table->boolean('spec_inside_seating')->default(false);
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
            $table->dropColumn('spec_techy', 'spec_student', 'spec_quiet', 'spec_relaxed', 'spec_urban',
                'spec_alternative', 'spec_artisan', 'spec_payable_wifi', 'spec_dogs_welcome', 'spec_in_and_out_seating',
                'spec_inside_seating');

            $table->boolean('spec_independent')->default(false);
            $table->boolean('spec_dog_friendly')->default(false);
            $table->boolean('spec_geek_friendly')->default(false);
        });
    }
}
