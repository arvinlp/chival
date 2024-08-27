<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_credits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->unsignedDecimal('credit', 64, 0)->nullable()->comment('left credits');
            $table->unsignedDecimal('total_credit', 64, 0)->nullable()->comment('total credits');
            $table->string('expire_date')->nullable()->useCurrent();
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
        Schema::dropIfExists('company_credits');
    }
}
