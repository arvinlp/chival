<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCenteralPcposTerminalUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centeral_pcpos_terminal_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('Company ID');
            $table->unsignedBigInteger('terminal_id')->comment('Company ID');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('terminal_id')->references('id')->on('centeral_pcpos_terminals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centeral_pcpos_terminal_users');
    }
}
