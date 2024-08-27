<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('route_code')->nullable()->default('-')->comment('route code in company');
            $table->string('name')->nullable();
            $table->integer('distance')->nullable();
            $table->integer('reject_number')->nullable();
            $table->unsignedBigInteger('travel_type_id')->comment('travel type is normal, exclusive, vip, etc.');
            $table->unsignedBigInteger('car_type_id')->nullable()->comment('vehicle type like riding,van');
            $table->unsignedBigInteger('destination_id')->nullable()->comment('destination ');

            $table->unsignedDecimal('insurance_passenger',16,0)->nullable()->default('0')->comment('passenger insurance amount');
            $table->unsignedDecimal('insurance_body',16,0)->nullable()->default('0')->comment('body insurance amount');

            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Remove row after company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        
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
        Schema::dropIfExists('routes');
    }
}
