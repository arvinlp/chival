<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('role_access_id');

            // Remove row after user removed
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Remove row after role removed
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            // Remove row after role removed
            $table->foreign('role_access_id')->references('id')->on('role_accesses')->onDelete('cascade');
        
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
        //
    }
}
