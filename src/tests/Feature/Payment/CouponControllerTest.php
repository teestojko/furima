<?php

namespace Tests\Feature\Coupon;

use Tests\TestCase;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function coupon_can_be_applied_correctly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create([
            'price' => 1000,
        ]);

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $coupon = Coupon::factory()->valid()->create([
            'user_id' => $user->id,
            'code' => 'TEST1234',
            'discount_type' => 'fixed',
            'discount' => 500,
            'is_used' => false,
        ]);

        $response = $this
            ->withSession(['selected_items' => [$cart->id]])
            ->post('/apply_coupon', [
                'coupon_code' => 'TEST1234',
                '_token' => csrf_token(),
            ]);

        $response->assertRedirect();

        $this->assertEquals(1500, session('discounted_amount'));

        $this->assertTrue($coupon->fresh()->is_used);
    }
}
