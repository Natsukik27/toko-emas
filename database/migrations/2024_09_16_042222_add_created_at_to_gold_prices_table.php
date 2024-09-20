<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedAtToGoldPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gold_prices', function (Blueprint $table) {
            if (!Schema::hasColumn('gold_prices', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gold_prices', function (Blueprint $table) {
            if (Schema::hasColumn('gold_prices', 'created_at')) {
                $table->dropColumn('created_at');
            }
        });
    }
}
