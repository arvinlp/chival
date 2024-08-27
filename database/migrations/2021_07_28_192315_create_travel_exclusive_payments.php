<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelExclusivePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * AccountType Share => ترتیب پر شدن لیست حتما باید مطابق ترتیب تعریف شده در سوئیچ پرداخت باشد.
     * AccountType Share_ByAmountIban => شناسه خرید,مبلغ,شناسه حساب; شناسه خرید,مبلغ,شناسه حساب; شناسه خرید,مبلغ,شناسه حساب
     * totalAmount
     *
     */
    public function up()
    {
        Schema::create('travel_exclusive_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_exclusive_id')->comment('Travel Exclusive identifier');
            $table->string('identifier')->nullable();
            $table->string('terminal_id')->nullable();
            $table->tinyInteger('account_type')->nullable()->comment('0 => Single, 1 => Share, 2 => Share_ByAmountIban');
            $table->string('res_num')->nullable();
            $table->text('user_notifiable')->nullable();
            $table->text('amount_iban')->nullable();
            $table->tinyInteger('transaction_type')->nullable()->comment('0 => Purchase, 1 => Bill, 2 => PurchaseID');
            

            $table->string('rrn')->nullable();
            $table->string('trace_number')->nullable();
            $table->string('response_description')->nullable();
            $table->string('amount')->nullable();

            $table->text('error_code')->nullable();
            $table->text('error_description')->nullable();

            $table->tinyInteger('status')->nullable()->default(1);
            
            $table->timestamps();


            $table->foreign('travel_exclusive_id')->references('id')->on('travel_exclusives')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_exclusive_payments');
    }
}
