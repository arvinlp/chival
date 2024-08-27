<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_passengers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_id')->comment('Travel identifier');
            $table->unsignedBigInteger('passenger_id')->comment('Passenger identifier');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('Parent Passenger if passenger payed for this');
            $table->integer('seat_number')->comment('Seat Number is Seat Location in Vehicle');
            $table->tinyInteger('child_number')->comment('if have Child');
            $table->tinyInteger('package_number')->comment('if have Package');
            $table->tinyInteger('sex')->default(0)->comment('IF Female set 1 ,IF Male set this 0');
            $table->integer('package')->default(0)->comment('Package Price of Seat Location in Vehicle');
            $table->integer('tax')->default(0)->comment('Tax of Seat Location in Vehicle');
            $table->integer('commission')->default(0)->comment('Company Commission of Seat Location in Vehicle');
            $table->integer('price')->default(0)->comment('Base Price of Seat Location in Vehicle');
            $table->integer('other_pay')->default(0)->comment('like record payment');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('discont')->nullable()->default(0);
            $table->unsignedInteger('payed')->nullable()->default(0);
            $table->enum('payment_type',['cash', 'online_payment', 'pcpos', 'associate']);
            $table->integer('payment_status')->default(0)->comment('0-99: cash-pay, 100-199: online-pay, 200-299: pcpos-pay');
            $table->timestamps();

            // Remove row after Travel removed
            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
            $table->foreign('passenger_id')->references('id')->on('passengers')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('travel_passengers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_passengers');
    }
}
