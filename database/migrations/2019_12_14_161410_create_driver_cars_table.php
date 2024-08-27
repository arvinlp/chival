<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('car_id');
            $table->tinyInteger('status')->unsigned()->nullable()->default(1)->comment('if status is 0 means car changed');


            // Remove row after Company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Remove row after Company removed
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');

            // Remove row after Company removed
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        
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
        Schema::dropIfExists('driver_cars');
    }
}
