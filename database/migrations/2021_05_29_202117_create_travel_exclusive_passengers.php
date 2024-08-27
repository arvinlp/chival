<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelExclusivePassengers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_exclusive_passengers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_exclusive_id')->comment('Travel Exclusive_id identifier');
            $table->unsignedBigInteger('passenger_id')->comment('Passenger identifier');

            // Remove row after Travel removed
            $table->foreign('travel_exclusive_id')->references('id')->on('travel_exclusives')->onDelete('cascade');
            $table->foreign('passenger_id')->references('id')->on('passengers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_exclusive_passengers');
    }
}
