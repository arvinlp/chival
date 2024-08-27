<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreroomSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storeroom_sends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('storeroom_id');
            $table->unsignedBigInteger('driver_id');

            $table->timestamp('date_send')->useCurrent();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after storage removed
            $table->foreign('storeroom_id')->references('id')->on('storerooms')->onDelete('cascade');

            // No Action
            $table->foreign('driver_id')->references('id')->on('drivers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storeroom_sends');
    }
}
