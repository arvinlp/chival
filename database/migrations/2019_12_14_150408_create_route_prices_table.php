<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('route_id');
            $table->integer('seat_number')->nullable()->default('0');
            $table->unsignedDecimal('price',16,0)->nullable()->default('0');
            $table->unsignedDecimal('tax',16,0)->nullable()->default('0');
            $table->unsignedDecimal('commission',16,0)->nullable()->default('0');
            $table->unsignedDecimal('passenger',16,0)->nullable()->default('0');

            // Remove row after route removed
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
        
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
        Schema::dropIfExists('route_prices');
    }
}
