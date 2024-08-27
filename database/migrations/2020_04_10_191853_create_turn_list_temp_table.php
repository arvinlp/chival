<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnListTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turn_list_temp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->comment('Company identifier');
            $table->unsignedBigInteger('driver_id')->comment('Driver identifier');
            $table->unsignedBigInteger('car_id')->comment('Vehicle identifier');
            $table->unsignedBigInteger('route_id')->comment('Route identifier');
            $table->unsignedBigInteger('travel_id')->nullable()->comment('Travel identifier');
            $table->unsignedBigInteger('driver_book_time_id')->comment('Driver Book Time identifier');
            $table->tinyInteger('status')->nullable()->default(25)->comment('25-50,40-50,50-70,70-90,90-95,95-100');
            $table->timestampTz('login', 0)->nullable();
            $table->timestamp('selling', 0)->nullable();
            $table->timestamp('logout', 0)->nullable();
            //
            $table->tinyInteger('travel_type')->comment('travel_type from travel_types.travel_type');
            $table->text('driver_card_no')->comment('driver_card_no from drivers.driver_card_no');
            $table->text('car_card_no')->comment('car_card_no from cars.car_card_no');
            $table->integer('orgin_city')->comment('Orgin City from destanestions.cites = companies.cites -> code');
            $table->integer('dest_city')->comment('Dest City from destanestions.id = routes.destination_id -> code');
            $table->unsignedDecimal('far_city',16,8)->comment('Far City from routes.distance');
            $table->integer('chairs_number')->default(0)->comment('Chairs Number from car_systems.capacity');
            $table->unsignedInteger('insurance_body')->comment('Insurance Body from routes.insurance_body');
            $table->unsignedInteger('insurance_third')->comment('Insurance Third from routes.insurance_third');
            $table->tinyInteger('car_type')->comment('Car Type from car_types.type');
            $table->text('plaque_number')->comment('plaque_number from cars.series1,series2,series3');
            $table->text('plaque_serial')->comment('plaque_serial from cars.series');
            //
            $table->text('note')->nullable();

            //
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turn_list');
    }
}
