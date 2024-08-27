<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->text('content')->nullable();
            $table->string('table', 100)->nullable();
            $table->text('where')->nullable();
            $table->set('type', ['insert','update', 'delete']);
            $table->set('user_type', ['admin', 'client'])->default('admin');
            $table->timestamps();
            $table->softDeletes();

            // Remove row after User removed
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Remove row after company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        
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
        Schema::dropIfExists('user_histories');
    }
}
