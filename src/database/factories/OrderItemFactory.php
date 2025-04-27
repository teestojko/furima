<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Cart;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $order = Order::factory()->create();
        $cart = Cart::factory()->create();

        if (!$cart || !$order || !$cart->product) {
            return [
                'order_id' => $order?->id ?? 1,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 1000,
                'commission_fee' => 50,
                'seller_revenue' => 950,
            ];
        }

        $productPrice = $cart->product->price;
        $quantity = $cart->quantity;
        $total = $productPrice * $quantity;

        $commissionRate = config('fees.commission_rate', 0.05);
        $fee = $total * $commissionRate;
        $revenue = $total - $fee;

        return [
            'order_id' => $order->id,
            'product_id' => $cart->product_id,
            'quantity' => $quantity,
            'price' => $productPrice,
            'commission_fee' => $fee,
            'seller_revenue' => $revenue,
        ];
    }
}
