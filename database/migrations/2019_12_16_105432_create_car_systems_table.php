<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_systems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->tinyInteger('capacity')->nullable()->comment('capacity of vehicle pasenger');
            $table->timestamps();
            $table->softDeletes();
        
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
        Schema::dropIfExists('car_systems');
    }
}
