<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('status_id')->constrained('order_statuses')->cascadeOnDelete();

            //$table->foreignId('status_id')->constrained('order_statuses')->restrictOnDelete();
            //order_statuses のレコードが削除されると、削除を制限する（関連する orders のレコードがある場合は削除できない）設定

            $table->integer('quantity'); // 購入数量
            $table->decimal('total_price', 10, 2); // 合計金額
            $table->timestamp('order_date'); // 注文日
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
        Schema::dropIfExists('orders');
    }
}
