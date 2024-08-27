<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_sellers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_id')->comment('Travel identifier');
            $table->unsignedBigInteger('turn_list_id')->comment('Turn List identifier');
            $table->unsignedBigInteger('user_id')->comment('User identifier');
            $table->tinyInteger('status')->comment('Which step by this user affected');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_sellers');
    }
}
