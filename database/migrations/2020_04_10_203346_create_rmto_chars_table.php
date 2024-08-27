<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRmtoCharsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rmto_chars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('char',8)->nullable()->comment('record sreies part 1 alphabet');
            $table->char('char_fa',8)->nullable()->comment('record sreies part 1 alphabet');
        });
        if (Schema::hasTable('rmto_chars')) {
            DB::insert("INSERT INTO `rmto_chars` (`id`, `char`, `char_fa`) VALUES
                        (1, 'A', 'آ'),
                        (2, 'B', 'ا'),
                        (3, 'C', 'ب'),
                        (4, 'D', 'پ'),
                        (5, 'E', 'ت'),
                        (6, 'F', 'ث'),
                        (7, 'G', 'ج'),
                        (8, 'H', 'چ'),
                        (9, 'a', 'ح'),
                        (10, 'b', 'خ'),
                        (11, 'c', 'د'),
                        (12, 'd', 'ذ'),
                        (13, 'e', 'ر'),
                        (14, 'f', 'ز'),
                        (15, 'g', 'ژ'),
                        (16, 'h', 'س'),
                        (17, 'i', 'ش'),
                        (18, 'j', 'ص'),
                        (19, 'k', 'ض'),
                        (20, 'l', 'ط'),
                        (21, 'm', 'ظ'),
                        (22, 'n', 'ع'),
                        (23, 'o', 'غ'),
                        (24, 'p', 'ف'),
                        (25, 'q', 'ق'),
                        (26, 'r', 'ک'),
                        (27, 's', 'گ'),
                        (28, 't', 'ل'),
                        (29, 'u', 'م'),
                        (30, 'v', 'ن'),
                        (31, 'w', 'و'),
                        (32, 'x', 'ه'),
                        (34, 'y', 'ی'),
                        (35, 'z', 'ئ');
                        ");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rmto_chars');
    }
}
