<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('condition_id');
            $table->integer('jumlah')->default(0);
            $table->string('satuan');
            $table->year('tahun_pengadaan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('location_id')->references('id')->on('locations');
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
        Schema::dropIfExists('items');
    }
}