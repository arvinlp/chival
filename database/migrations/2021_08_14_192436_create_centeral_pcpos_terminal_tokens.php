<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCenteralPcposTerminalTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centeral_pcpos_terminal_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('access_token')->nullable();
            $table->string('token_type')->nullable();
            $table->string('expires_in')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->string('refresh_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centeral_pcpos_terminal_tokens');
    }
}
