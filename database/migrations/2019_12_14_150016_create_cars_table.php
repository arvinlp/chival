<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('owner_id');

            $table->unsignedBigInteger('route_id')->nullable()->comment('allowed vehicle routes');
            $table->unsignedBigInteger('car_type_id')->nullable()->comment('vehicle type like riding,van');
            $table->unsignedBigInteger('car_system_id')->nullable()->comment('vehicle system type peugeot');
            $table->unsignedBigInteger('insurance_id')->nullable()->comment('vehicle people insurances');
            $table->unsignedBigInteger('insurance_body_id')->nullable()->comment('vehicle body insurances');
            $table->unsignedBigInteger('technical_diagnose_id')->nullable()->comment('vehicle technical diagnose');

            $table->char('car_code',16)->nullable()->comment('vehicle code in the company');
            $table->char('car_card_no',32)->nullable()->comment('vehicle card number');
            $table->char('vin',32)->nullable()->comment('vehicle VIN number');
            $table->integer('year')->unsigned()->nullable()->default(1300)->comment('vehicle made year');
            $table->tinyInteger('fuel')->unsigned()->nullable()->default(1)->comment('vehicle fuel type');
            $table->tinyInteger('capacity')->nullable()->comment('capacity of vehicle pasenger');
            $table->text('status_note')->nullable()->comment('vehicle card number status note');

            $table->char('plate_series',4)->nullable()->comment('vehicle plate series state');
            $table->char('plate_series_1',6)->nullable()->comment('vehicle plate like 123');
            $table->char('plate_series_2',4)->nullable()->comment('vehicle plate alphabet like a');
            $table->char('plate_series_2_en',4)->nullable()->comment('vehicle plate alphabet like a');
            $table->char('plate_series_3',4)->nullable()->comment('vehicle plate like 23');

            $table->tinyInteger('insurance_body')->unsigned()->nullable()->default(1)->comment('vehicle have body insurance');

            $table->tinyInteger('status')->unsigned()->nullable()->default(1)->comment('vehicle status');
            $table->timestamps();
            $table->softDeletes();

            // Remove row after Company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Remove row after owner removed
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
