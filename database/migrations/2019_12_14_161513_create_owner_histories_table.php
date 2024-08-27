<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('car_id');

            $table->char('old_car_card_no',32)->nullable()->comment('vehicle card number');
            $table->char('old_vin',32)->nullable()->comment('vehicle VIN number');
            $table->integer('old_year')->unsigned()->nullable()->default(1300)->comment('vehicle made year');
            $table->tinyInteger('old_fuel')->unsigned()->nullable()->default(1)->comment('vehicle fuel type');
            $table->tinyInteger('old_capacity')->nullable()->comment('capacity of vehicle pasenger');
            $table->text('old_status_note')->nullable()->comment('vehicle card number status note');

            $table->char('old_plate_series',4)->nullable()->comment('vehicle plate series state');
            $table->char('old_plate_series_1',6)->nullable()->comment('vehicle plate like 123');
            $table->char('old_plate_series_2',2)->nullable()->comment('vehicle plate alphabet like a');
            $table->char('old_plate_series_2_en',4)->nullable()->comment('vehicle plate alphabet like a');
            $table->char('old_plate_series_3',4)->nullable()->comment('vehicle plate like 23');

            $table->tinyInteger('old_insurance_body')->unsigned()->nullable()->default(1)->comment('vehicle have body insurance');

            $table->timestamps();
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after owner removed
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');

            // Remove row after car removed
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owner_histories');
    }
}
