<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('loan_id');
            $table->date('tanggal_kembali');
            $table->unsignedBigInteger('condition_id');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('loan_id')->references('id')->on('loans');
            $table->foreign('condition_id')->references('id')->on('conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_returns');
    }
}