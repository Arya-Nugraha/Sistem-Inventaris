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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_supplier');
            $table->integer('jumlah');
            $table->date('tanggal_masuk');
            $table->string('keterangan');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_barang')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_supplier')->references('id')->on('supplier')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
