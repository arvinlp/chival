<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('module_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamp('expire_date')->useCurrent();
            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->softDeletes();

            // Remove row after module removed
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');

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
        Schema::dropIfExists('company_modules');
    }
}
