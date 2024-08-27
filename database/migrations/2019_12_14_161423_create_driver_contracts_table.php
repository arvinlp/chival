<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('driver_id');
            $table->bigInteger('number')->nullable()->comment('company contract`s number');
            $table->string('expire_date')->nullable();
            $table->text('file')->nullable()->comment('driver contract`s file');
            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after Company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Remove row after Company removed
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_contracts');
    }
}
