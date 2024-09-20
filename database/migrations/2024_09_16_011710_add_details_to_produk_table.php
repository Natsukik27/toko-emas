<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->decimal('berat', 8, 2)->after('nama_produk');
            $table->integer('kadar')->after('berat');
            $table->decimal('harga_per_gram', 10, 2)->after('kadar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('berat');
            $table->dropColumn('kadar');
            $table->dropColumn('harga_per_gram');
        });
    }
}
