<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('car_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('driver_book_id')->nullable();

            $table->string('fname', 100)->nullable();
            $table->string('lname', 200)->nullable();
            $table->string('father', 100)->nullable();
            $table->string('nation_code',11)->nullable();
            $table->string('birthday',100)->nullable();
            $table->tinyInteger('marital_status')->nullable();
            $table->tinyInteger('sex')->unsigned()->nullable()->default(1);
            $table->char('tel',14)->nullable();
            $table->char('mobile',14)->nullable();
            $table->string('password')->nullable();
            $table->unsignedSmallInteger('province')->nullable();
            $table->unsignedSmallInteger('county')->nullable();
            $table->unsignedSmallInteger('city')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code',100)->nullable();
            $table->string('rmto_city',100)->nullable();
            $table->text('picture')->nullable()->comment('driver`s picture');

            $table->string('driver_code')->nullable()->comment('driver code in company');
            $table->string('driver_card_no')->nullable()->comment('driver card number');
            $table->string('driver_license')->nullable()->comment('driver`s license');
            $table->string('driver_health')->nullable()->comment('driver`s health card');
            $table->tinyInteger('driver_health_status')->unsigned()->nullable()->comment('driver`s health card status');
            $table->tinyInteger('driver_license_status')->unsigned()->nullable()->default(1)->comment('driver`s license status');
            $table->string('driver_health_expire',100)->nullable()->comment('driver`s health card expire date');
            $table->string('driver_card_no_expire',100)->nullable()->comment('driver`s license expire date');
            $table->string('driver_license_expire',100)->nullable()->comment('driver`s license expire date');
            $table->text('driver_note')->nullable()->comment('driver`s license status note');

            $table->double('insurance_price',16,0)->nullable()->comment('insurance montly amount');
            $table->tinyInteger('insurance_people')->nullable()->comment('insurance covered people');
            $table->tinyInteger('insurance_number')->nullable()->comment('insurance deduction from the statement of condition');
            $table->double('insurance_amount',16,0)->nullable()->comment('the sum of each fraction of the statement of condition');

            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('bank_number')->nullable()->comment('driver`s back account number');
            $table->string('bank_iban')->nullable()->comment('driver`s international bank account number');
            $table->string('bank_card')->nullable()->comment('driver`s bank card');

            $table->tinyInteger('status')->unsigned()->nullable()->default(1)->comment('driver`s status');

            $table->timestamps();
            $table->softDeletes();

            // Remove row after Company removed
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
        Schema::dropIfExists('drivers');
    }
}
