<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreroomPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storeroom_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('storeroom_id');
            $table->unsignedBigInteger('reciver_user_id');
            $table->unsignedBigInteger('location_id')->comment('is sotrage_location_id');
            $table->unsignedBigInteger('position_id')->comment('is sotrage_location_id');
            $table->string('row')->nullable()->default('-');
            $table->string('cloumn')->nullable()->default('-');
            $table->text('storage_description')->nullable();
            $table->unsignedDecimal('amount_maintenance',16,0)->nullable()->default('0');

            $table->timestamp('date_received')->useCurrent();
            $table->timestamp('date_delivered')->nullable();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after Company removed
            $table->foreign('storeroom_id')->references('id')->on('storerooms')->onDelete('cascade');

            $table->foreign('location_id')->references('id')->on('storeroom_locations');
            $table->foreign('position_id')->references('id')->on('storeroom_locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storeroom_packages');
    }
}
