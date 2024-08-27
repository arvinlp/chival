<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storerooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('receiver_company_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_destination_id');
            $table->unsignedBigInteger('package_type_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('reciver_id');

            $table->timestamp('date_login')->useCurrent();

            $table->unsignedDecimal('weight',10,6)->nullable()->default('0');
            $table->unsignedDecimal('amount_value',16,0)->nullable()->default('0');
            $table->unsignedDecimal('amount_service',16,0)->nullable()->default('0');
            $table->unsignedDecimal('amount_send',16,0)->nullable()->default('0');
            $table->unsignedDecimal('amount_final',16,0)->nullable()->default('0');
            $table->text('description')->nullable();

            $table->tinyInteger('services')->unsigned()->nullable()->default(0);
            $table->tinyInteger('insurance')->unsigned()->nullable()->default(0);
            $table->tinyInteger('recive_to')->unsigned()->nullable()->default(1);
            $table->tinyInteger('sms_status')->unsigned()->nullable()->default(0);

            $table->tinyInteger('status')->unsigned()->nullable()->default(100);
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');

            // Remove row after Company removed
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('receiver_company_id')->references('id')->on('companies')->onDelete('cascade');

            // No Action
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storerooms');
    }
}
