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
            $table->unsignedBigInteger('customer_type_id')->index();
            $table->unsignedSmallInteger('quantity');
            $table->unsignedFloat('price');
            $table->dateTime('entry_date');
            $table->dateTime('exit_date')->nullable();
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
