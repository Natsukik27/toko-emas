<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained()->onDelete('cascade'); // Foreign key to Produk
            $table->decimal('berat', 8, 2); // Berat emas
            $table->decimal('harga_per_gram', 10, 2); // Harga per gram
            $table->decimal('total_harga', 10, 2); // Total harga
            $table->string('pelanggan'); // Nama pelanggan
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
        Schema::dropIfExists('transaksis');
    }
}
