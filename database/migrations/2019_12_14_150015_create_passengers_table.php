<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fname', 100)->nullable();
            $table->string('lname', 200)->nullable();
            $table->string('father', 100)->nullable();
            $table->string('nation_code',11)->nullable();
            $table->string('birthday',100)->nullable();
            $table->tinyInteger('marital_status')->nullable();
            $table->tinyInteger('sex')->unsigned()->nullable()->default(1);
            $table->char('tel',14)->nullable();
            $table->char('mobile',14)->nullable();
            $table->unsignedSmallInteger('province')->nullable();
            $table->unsignedSmallInteger('county')->nullable();
            $table->unsignedSmallInteger('city')->nullable();
            $table->text('address')->nullable();

            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
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
        Schema::dropIfExists('passengers');
    }
}
