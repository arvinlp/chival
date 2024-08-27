<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('support_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after Company removed
            $table->foreign('support_id')->references('id')->on('supports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_tickets');
    }
}
