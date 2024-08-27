<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliceStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('police_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->unsignedInteger('radius')->nullable();
            $table->unsignedSmallInteger('province')->nullable();
            $table->unsignedSmallInteger('county')->nullable();
            $table->unsignedSmallInteger('city')->nullable();
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
        Schema::dropIfExists('police_stations');
    }
}
