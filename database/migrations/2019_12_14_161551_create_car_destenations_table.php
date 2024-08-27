<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarDestenationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_destenations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('destenation_id')->nullable();
            $table->char('car_code',16)->nullable()->comment('vehicle code in the company');
            $table->timestamps();
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Remove row after car removed
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');

            // Remove row after destenation removed
            $table->foreign('destenation_id')->references('id')->on('destinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_destenations');
    }
}
