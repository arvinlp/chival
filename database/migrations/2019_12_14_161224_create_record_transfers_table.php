<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('of_user_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('record_id');

            $table->integer('pages')->nullable();
            $table->integer('of')->nullable();
            $table->integer('to')->nullable();

            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Remove row after user removed
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Remove row after user removed
            $table->foreign('of_user_id')->references('id')->on('users')->onDelete('cascade');

            // Remove row after Company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Remove row after Record removed
            $table->foreign('record_id')->references('id')->on('records')->onDelete('cascade');
        
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
        Schema::dropIfExists('record_transfers');
    }
}
