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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel transaksis
            $table->foreignId('transaksi_id')
                ->constrained('transaksis')
                ->onDelete('cascade');

            // Foreign Key ke tabel laundry_items
            $table->foreignId('layanan_id')
                ->constrained('layanans')
                ->onDelete('cascade');

            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
