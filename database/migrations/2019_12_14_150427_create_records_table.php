<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('code')->nullable()->default('0');
            $table->char('series1',16)->nullable()->default('0')->comment('record sreies part 1 alphabet');
            $table->char('series1_en',8)->nullable()->default('0')->comment('record sreies part 1 alphabet');
            $table->char('series2',16)->nullable()->default('0')->comment('record sreies part 2 like 12345');
            $table->char('series3',16)->nullable()->default('0')->comment('record sreies part 3 like 12345');
            $table->unsignedBigInteger('travel_type_id')->comment('travel type is normal, exclusive, vip, etc.');
            $table->integer('pages')->nullable()->default('0');
            $table->integer('of')->nullable()->default('0');
            $table->integer('to')->nullable()->default('0');
            $table->integer('used')->nullable()->default('0');
            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('records');
    }
}
