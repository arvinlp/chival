<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('support_department_id');
            $table->string('name')->nullable();
            $table->longText('content')->nullable();
            $table->tinyInteger('status')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
            
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after Company removed
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
        Schema::dropIfExists('supports');
    }
}
