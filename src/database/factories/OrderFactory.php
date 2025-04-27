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
        $totalPrice = $this->faker->randomFloat(2, 1000, 10000);
        $commissionRate = config('fees.commission_rate');
        $commissionFee = $totalPrice * $commissionRate;
        $sellerRevenue = $totalPrice - $commissionFee;

        return [
            'user_id' => User::factory()->create(),
            'status_id' => OrderStatus::factory()->create(),
            'total_price' => $totalPrice,
            'commission_fee' => $commissionFee,
            'seller_revenue' => $sellerRevenue,
            'order_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
