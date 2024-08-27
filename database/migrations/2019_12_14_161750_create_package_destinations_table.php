<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_destinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedSmallInteger('province')->nullable();
            $table->unsignedSmallInteger('county')->nullable();
            $table->unsignedSmallInteger('city')->nullable();
            $table->string('name')->nullable()->default('-');
            $table->unsignedDecimal('amount',16,0)->nullable()->default('0')->comment('send package to this city have main amount');
            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after Company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_destinations');
    }
}
