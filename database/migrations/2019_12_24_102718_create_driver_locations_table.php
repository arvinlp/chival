<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('driver_id')->comment('Driver identifier');
            $table->unsignedBigInteger('travel_id')->comment('Travel identifier');
            $table->unsignedDecimal('speed', 64, 0)->nullable()->comment('Speed km/h');
            $table->unsignedDecimal('latitude', 64, 0)->nullable()->comment('Latitude is width');
            $table->unsignedDecimal('longitude', 64, 0)->nullable()->comment('Longitude is height');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_locations');
    }
}
