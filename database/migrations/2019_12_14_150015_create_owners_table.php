<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedSmallInteger('province')->nullable();
            $table->unsignedSmallInteger('county')->nullable();
            $table->unsignedSmallInteger('city')->nullable();

            $table->string('name', 255)->nullable();
            $table->string('fname', 100)->nullable();
            $table->string('lname', 200)->nullable();
            $table->string('father', 100)->nullable();
            $table->string('nation_code',11)->nullable();
            $table->string('birthday',100)->nullable();
            $table->tinyInteger('marital_status')->nullable();
            $table->tinyInteger('sex')->unsigned()->nullable()->default(1);
            $table->char('tel',14)->nullable();
            $table->char('mobile',14)->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code',100)->nullable();

            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Remove row after Company removed
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
        Schema::dropIfExists('owners');
    }
}
