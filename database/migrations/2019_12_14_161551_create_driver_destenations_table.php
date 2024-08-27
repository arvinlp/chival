<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverDestenationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_destenations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('destenation_id')->nullable();
            $table->string('driver_code')->nullable()->comment('driver code in the company');
            $table->timestamps();
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Remove row after driver removed
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');

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
