<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prediksi', function (Blueprint $table) {
            $table->id();

            $table->string('kode_produk');
            $table->string('nama_produk');

            $table->decimal('alpha', 5, 2);
            $table->decimal('beta', 5, 2);

            $table->integer('periode_prediksi');
            
            $table->decimal('mad', 12, 4);
            $table->decimal('mse', 12, 4);
            $table->decimal('mape', 12, 4);

            $table->longText('peramalan');

            $table->date('tanggal');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prediksi');
    }
};