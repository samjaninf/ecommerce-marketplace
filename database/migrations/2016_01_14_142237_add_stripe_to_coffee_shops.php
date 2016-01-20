<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripeToCoffeeShops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coffee_shops', function (Blueprint $table) {
            $table->string('stripe_token_type');
            $table->string('stripe_publishable_key');
            $table->string('stripe_scope');
            $table->string('stripe_livemode');
            $table->string('stripe_user_id');
            $table->string('stripe_refresh_token');
            $table->string('stripe_access_token');
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
            $table->dropColumn('stripe_token_type');
            $table->dropColumn('stripe_publishable_key');
            $table->dropColumn('stripe_scope');
            $table->dropColumn('stripe_livemode');
            $table->dropColumn('stripe_user_id');
            $table->dropColumn('stripe_refresh_token');
            $table->dropColumn('stripe_access_token');
        });
    }
}
