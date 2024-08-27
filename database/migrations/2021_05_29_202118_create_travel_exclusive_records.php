<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelExclusiveRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_exclusive_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_exclusive_id')->comment('Travel Exclusive identifier');
            $table->unsignedBigInteger('record_id')->nullable()->comment('Record identifier');
            $table->unsignedBigInteger('chival_record_id')->nullable()->comment('Record identifier');
            $table->string('mosng')->comment('mosng is record code number and this number should between records.of and records.to');
            $table->string('seri')->comment('seri from records.series1,series2,series3');
            $table->string('seri_show')->comment('seri_show from records.series1,series2,series3 and mosng');
            $table->string('system_code')->nullable()->comment('Tracking code recived from rmto server');
            $table->string('chival_code')->nullable()->comment('Tracking code recived from chival server');
            $table->text('note');
            $table->tinyInteger('status')->nullable()->default(0)->comment('0 is offline, 1 is online, 100 is done');
            $table->timestamps();

            // Remove row after Travel removed
            $table->foreign('travel_exclusive_id')->references('id')->on('travel_exclusives')->onDelete('cascade');
            $table->foreign('record_id')->references('id')->on('records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_exclusive_records');
    }
}
