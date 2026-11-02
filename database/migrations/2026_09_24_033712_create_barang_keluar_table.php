<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {  
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->integer('jumlah');
            $table->date('tanggal_keluar');
            $table->string('penerima',100)->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_barang')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
