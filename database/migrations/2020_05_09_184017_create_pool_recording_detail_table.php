<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolRecordingDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_recording_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pool_record_id');
            $table->unsignedBigInteger('customer_type_id');
            $table->unsignedSmallInteger('quantity');
            $table->unsignedFloat('price');
            $table->dateTime('entry_date');
            $table->dateTime('exit_date')->nullable();

            $table->foreign('pool_record_id')->references('id')->on('pool_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pool_recording_detail');
    }
}
