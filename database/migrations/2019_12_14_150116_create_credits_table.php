<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->char('cycle',4)->nullable();
            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->unsignedDecimal('amount', 16, 0)->nullable();
            $table->unsignedDecimal('credit', 32, 0)->nullable();
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
        Schema::dropIfExists('creadits');
    }
}
