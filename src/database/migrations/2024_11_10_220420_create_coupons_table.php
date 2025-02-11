<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('code')->unique(); // クーポンコード
            $table->decimal('discount', 8, 2); // 割引額またはパーセンテージ
            $table->enum('discount_type', ['fixed', 'percentage']); // 割引のタイプ
            $table->date('valid_from')->nullable(); // 有効開始日
            $table->date('valid_until')->nullable(); // 有効期限
            $table->boolean('is_active')->default(true); // クーポンの有効/無効
            $table->boolean('is_used')->default(false); // 使用済みかどうかを判定
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
        Schema::dropIfExists('coupons');
    }
}
