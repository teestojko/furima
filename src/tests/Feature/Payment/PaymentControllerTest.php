<?php

namespace Tests\Feature\Payment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Mockery;
use Mockery\MockInterface;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function payment_successfully_creates_order_and_reduces_points()
    {
        // Stripe関連クラスのメソッドをモックする
        $customerMock = Mockery::mock('overload:Stripe\Customer');
        $customerMock->shouldReceive('create')->andReturn((object)['id' => 'cus_test']);

        $chargeMock = Mockery::mock('overload:Stripe\Charge');
        $chargeMock->shouldReceive('create')->andReturn((object)['id' => 'ch_test']);

        $user = User::factory()->create(['points' => 1000]);
        $this->actingAs($user);

        $product = Product::factory()->create(['price' => 1000]);
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        OrderStatus::factory()->create([
            'id' => 2,
            'name' => '完了',
        ]);

        session([
            'selected_items' => [$cart->id],
            'total_amount' => 1000,
            'discounted_amount' => 1000,
            'used_points' => 200,
        ]);

        $selectedItems = Cart::whereIn('id', session('selected_items'))->where('user_id', $user->id)->with('product')->get();
        $totalAmount = $selectedItems->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        $coupon = session('applied_coupon');
        if ($coupon) {
            if ($coupon->discount_type === 'fixed') {
                $discountedAmount = max(0, $totalAmount - $coupon->discount);
            } elseif ($coupon->discount_type === 'percentage') {
                $discountedAmount = $totalAmount * (1 - ($coupon->discount / 100));
            }
            session(['discounted_amount' => $discountedAmount]);
        } else {
            session(['discounted_amount' => $totalAmount]);
        }

        $finalAmount = session('total_amount') - session('used_points');

        $pointsRefunded = (int) ($finalAmount * 0.01);
        $finalAmountAfterRefund = $finalAmount - $pointsRefunded;

        $response = $this->post(route('payment-process'), [
            '_token' => csrf_token(),
            'stripeToken' => 'tok_visa',
            'stripeEmail' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status_id' => 2,
            'total_price' => 800,
        ]);

        $this->assertEquals(808, $user->fresh()->points);

        $response->assertRedirect(route('payment-success'));
        $response->assertSessionHas('success', "{$pointsRefunded} ポイントを獲得しました！");

    }
}
