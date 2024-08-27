<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('nation_code')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->char('mobile',14)->unique();
            $table->tinyInteger('sex')->unsigned()->nullable()->default(1);
            $table->timestamp('birthday',0)->useCurrent();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->text('img')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->timestamp('last_login')->useCurrent();
            $table->set('type', ['admin', 'client'])->default('admin');
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
        Schema::dropIfExists('users');
    }
}
