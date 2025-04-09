<?php

namespace tests\Feature\Coupon;

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
        // 1. ユーザー作成 & ログイン
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2. 商品作成（価格1000円）
        $product = Product::factory()->create([
            'price' => 1000,
        ]);

        // 3. カートに商品追加（数量2）
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // 4. 有効なクーポン作成（500円固定値引き）
        $coupon = Coupon::factory()->valid()->create([
            'user_id' => $user->id,
            'code' => 'TEST1234',
            'discount_type' => 'fixed',
            'discount' => 500,
            'is_used' => false,
        ]);

        // 5. クーポン適用リクエストを送信（セッション付き）
        $response = $this
            ->withSession(['selected_items' => [$cart->id]])
            ->post('/coupons/apply', [
                'coupon_code' => 'TEST1234',
                '_token' => csrf_token(),
            ]);

        // 6. リダイレクトされるか確認
        $response->assertRedirect();

        // 7. セッションに割引後の金額が保存されているか確認（1000 * 2 - 500 = 1500）
        $this->assertEquals(1500, session('discounted_amount'));

        // 8. クーポンが使用済み（is_used = true）になっているか確認
        $this->assertTrue($coupon->fresh()->is_used);
    }
}
