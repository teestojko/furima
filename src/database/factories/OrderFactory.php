<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatus;

class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // ランダムに生成する総額
        $totalPrice = $this->faker->randomFloat(2, 1000, 10000);

        // config/fees.php から手数料率を取得
        $commissionRate = config('fees.commission_rate');

        // 手数料を計算
        $commissionFee = $totalPrice * $commissionRate;

        // 出品者の収益は、総額から手数料を引いた金額
        $sellerRevenue = $totalPrice - $commissionFee;

        return [
            'user_id' => User::inRandomOrder()->first()->id, // ランダムなユーザー
            'status_id' => OrderStatus::inRandomOrder()->first()->id, // ランダムな注文ステータス
            'total_price' => $totalPrice, // ランダムな金額
            'commission_fee' => $commissionFee, // 計算された手数料
            'seller_revenue' => $sellerRevenue, // 計算された出品者の収益
            'order_date' => $this->faker->dateTimeThisYear(), // ランダムな注文日
        ];
    }
}
