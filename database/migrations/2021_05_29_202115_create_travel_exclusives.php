<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelExclusives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_exclusives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('chival_code')->nullable()->comment('Chival Code');

            $table->string('travel_duration')->nullable()->comment('Travel Duration');
            $table->tinyInteger('travel_duration_type')->default(0)->comment('0 is Day, 1 is Hour');
            $table->string('stop_duration')->nullable()->comment('Stop Duration');
            $table->tinyInteger('stop_duration_type')->default(0)->comment('0 is Day, 1 is Hour');
            $table->tinyInteger('travel_way_type')->default(0)->comment('0 is One Way, 1 is Two Way');
            $table->string('time_leave')->nullable()->comment('Time Leave');
            $table->string('date_leave')->nullable()->comment('Date Leave');
            $table->string('contract_number')->nullable()->comment('Contract Number');
            $table->string('contract_date')->nullable()->comment('Contract Date');
            $table->string('contract_person')->nullable()->comment('Contract Person');
            $table->unsignedBigInteger('company_id')->comment('Company identifier');
            $table->unsignedBigInteger('driver_id')->comment('Driver identifier');
            $table->unsignedBigInteger('driver_id_2')->nullable()->comment('Driver identifier Second');
            $table->unsignedBigInteger('driver_id_3')->nullable()->comment('Driver identifier Third');
            $table->unsignedBigInteger('car_id')->comment('Vehicle identifier');
            //
            $table->tinyInteger('travel_type')->comment('travel_type from travel_types.travel_type');
            $table->string('driver_card_no')->comment('driver_card_no from drivers.driver_card_no');
            $table->string('driver_card_no2')->comment('driver_card_no from drivers.driver_card_no');
            $table->string('driver_card_no3')->comment('driver_card_no from drivers.driver_card_no');
            $table->string('car_card_no')->comment('car_card_no from cars.car_card_no');
            $table->integer('orgin_city')->comment('Orgin City from destanestions.cites = companies.cites -> code');
            $table->integer('dest_city')->comment('Dest City from destanestions.id = routes.destination_id -> code');
            $table->unsignedDecimal('far_city',16,8)->comment('Far City from routes.distance');
            $table->integer('chairs_number')->default(0)->comment('Chairs Number from car_systems.capacity');
            $table->unsignedInteger('insurance_body')->comment('Insurance Body from routes.insurance_body');
            $table->unsignedInteger('insurance_third')->comment('Insurance Third from routes.insurance_third');
            $table->tinyInteger('car_type')->comment('Car Type from car_types.type');
            $table->string('plaque_number')->comment('plaque_number from cars.series1,series2,series3');
            $table->string('plaque_serial')->comment('plaque_serial from cars.series');
            //
            $table->integer('kilometer_price')->default(0)->comment('Kilometer Price');
            $table->integer('stop_base_price')->default(0)->comment('Stop Base Price');
            $table->integer('stop_total_price')->default(0)->comment('Stop Total Price');
            //
            $table->integer('package')->default(0)->comment('Sum Package Price');
            $table->integer('tax')->default(0)->comment('Sum Tax');
            $table->integer('commission')->default(0)->comment('Sum Company Commission');
            $table->integer('price')->default(0)->comment('Sum Base Price');
            $table->integer('insurance')->default(0)->comment('Insurance');
            //
            $table->unsignedInteger('coast')->nullable()->comment('Coast is sum basic price for all seats was sell from route_prices.price');
            $table->unsignedInteger('amount')->nullable();
            $table->unsignedInteger('driver_coast')->nullable();
            $table->unsignedInteger('total_amount')->nullable();
            $table->unsignedInteger('discont')->nullable()->default(0);
            //
            $table->tinyInteger('package_number')->nullable()->default(0)->comment('Package Number');
            $table->tinyInteger('passenger_number')->nullable()->comment('Passenger Number');
            $table->date('move_date', 0)->nullable()->comment('Travel Date Start');
            $table->dateTime('move_time', 0)->nullable()->comment('Travel Time Start');
            $table->tinyInteger('status')->nullable()->default(10)->comment('0-10,10-20,20-30,100');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Remove row after Company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            // $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            // $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_exclusives');
    }
}
