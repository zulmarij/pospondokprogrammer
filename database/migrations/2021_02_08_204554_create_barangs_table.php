<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->bigInteger('uid')->unique();
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
            $table->unsignedBigInteger('kategori_id');
            $table->string('merk');
            $table->integer('stock');
            $table->integer('diskon');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategoris')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
