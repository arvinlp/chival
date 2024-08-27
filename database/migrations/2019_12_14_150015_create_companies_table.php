<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_code')->nullable()->default('-')->comment('company registration code');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('tell')->nullable();
            $table->string('mobile')->nullable()->default('-')->comment('company manager or it manager mobile');
            $table->string('postal_code')->nullable();
            $table->text('address')->nullable();
            $table->unsignedSmallInteger('province')->nullable();
            $table->unsignedSmallInteger('county')->nullable();
            $table->unsignedSmallInteger('city')->nullable();
            $table->unsignedBigInteger('rmto_city')->nullable()->comment('is rmto destenation code');
            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->text('img')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');
        });

        Schema::table('users', function (Blueprint $table) {
            
            // Remove row after company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
