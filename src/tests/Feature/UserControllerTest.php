<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Review;
use App\Models\Tag;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_index_with_authenticated_user()
    {
        // テスト用ユーザーを作成
        $user = User::factory()->create();

        // ユーザーでログイン
        $this->actingAs($user);

        // 必要なデータを作成
        $cart = Cart::factory()->create();
        $category = Category::factory()->create();
        $order = Order::factory()->create();
        $orderStatus = OrderStatus::factory()->create();
        $product = Product::factory()->create();
        $review = Review::factory()->create();
        $tag = Tag::factory()->create();
        $coupon = Coupon::factory()->create();

        // エンドポイントにアクセス
        $response = $this->get('/user'); // 実際のルートを設定してください

        // レスポンスが200かを確認
        $response->assertStatus(200);

        // ビューに必要なデータが渡されているかを確認
        $response->assertViewHas('user_name', $user->name);
        $response->assertViewHas('user', $user);
        $response->assertViewHas('carts');
        $response->assertViewHas('categories');
        $response->assertViewHas('orders');
        $response->assertViewHas('order_status');
        $response->assertViewHas('products');
        $response->assertViewHas('reviews');
        $response->assertViewHas('tags');
        $response->assertViewHas('points');
        $response->assertViewHas('coupons');
    }

    public function test_user_index_without_authenticated_user()
    {
        // 未認証のユーザーとしてアクセス
        $response = $this->get('/user');

        // リダイレクトされることを確認（認証が必要な場合）
        $response->assertRedirect('/login');
    }
}
