<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengerPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * AccountType Share => ترتیب پر شدن لیست حتما باید مطابق ترتیب تعریف شده در سوئیچ پرداخت باشد.
     * AccountType Share_ByAmountIban => شناسه خرید,مبلغ,شناسه حساب; شناسه خرید,مبلغ,شناسه حساب; شناسه خرید,مبلغ,شناسه حساب
     * totalAmount
     */
    public function up()
    {
        Schema::create('passenger_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_id')->comment('Travel identifier');
            $table->unsignedBigInteger('passenger_travel_id')->comment('Passenger Travel identifier');
            //
            $table->string('identifier')->nullable();
            $table->string('terminal_id')->nullable();
            $table->tinyInteger('account_type')->nullable()->comment('0 => Single, 1 => Share, 2 => Share_ByAmountIban');
            $table->string('res_num')->nullable();
            $table->text('user_notifiable')->nullable();
            $table->text('amount_iban')->nullable();
            $table->tinyInteger('transaction_type')->nullable()->comment('0 => Purchase, 1 => Bill, 2 => PurchaseID');
            //
            $table->string('rrn')->nullable();
            $table->string('trace_number')->nullable();
            $table->string('response_description')->nullable();
            $table->string('amount')->nullable();
            //
            $table->text('error_code')->nullable();
            $table->text('error_description')->nullable();
            //
            $table->tinyInteger('status')->nullable()->default(1);
            //
            $table->timestamps();
            //
            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passenger_payments');
    }
}
