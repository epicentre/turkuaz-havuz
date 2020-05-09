<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_records', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no')->index();
            $table->unsignedTinyInteger('customer_count');
            $table->unsignedFloat('total_price');
            $table->unsignedTinyInteger('status')->default(0)->comment('0=> Giriş, 1=> Çıkış');
            $table->date('day')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pool_records');
    }
}
