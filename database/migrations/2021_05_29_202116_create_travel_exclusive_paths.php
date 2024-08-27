<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelExclusivePaths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_exclusive_paths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_exclusive_id')->comment('Travel Exclusive identifier');
            $table->unsignedBigInteger('destination_id')->comment('Destination identifier');
            $table->tinyInteger('type')->default(0)->comment('0 meaning go, 1 meaning return');
            $table->tinyInteger('order_by')->default(0);

            // Remove row after Travel Exclusive removed
            $table->foreign('travel_exclusive_id')->references('id')->on('travel_exclusives')->onDelete('cascade');
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_exclusive_paths');
    }
}
