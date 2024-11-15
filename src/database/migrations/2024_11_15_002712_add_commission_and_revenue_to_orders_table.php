<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommissionAndRevenueToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('commission_fee', 10, 2)->after('total_price'); // 手数料
            $table->decimal('seller_revenue', 10, 2)->after('commission_fee'); // 出品者の収益
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('commission_fee');
            $table->dropColumn('seller_revenue');
        });
    }
}
