<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnListUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turn_list_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('turn_list_id')->comment('Turn List identifier');
            $table->unsignedBigInteger('user_id')->comment('User identifier'); 
            $table->tinyInteger('status')->comment('Which step by this user affected');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turn_list_users');
    }
}
