<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_see_index_page_with_products_and_coupons()
    {
        // ユーザー作成
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        // ユーザーにポイント属性がある場合（仮にカラムが 'points' なら）
        $user->points = 5000;
        $user->save();

        // カテゴリ作成
        $category = Category::factory()->create();

        // 商品と画像を作成
        $product = Product::factory()->create([
            'name' => 'テスト商品',
            'price' => 12345,
            'category_id' => $category->id,
        ]);

        Image::factory()->create([
            'product_id' => $product->id,
            'path' => 'images/test.jpg',
        ]);

        // クーポン作成
        $coupon = Coupon::factory()->create([
            'code' => 'TESTCOUPON',
            'discount' => 10,
            'discount_type' => 'percentage',
            'user_id' => null,
        ]);

        // 認証状態で index にアクセス
        $response = $this->actingAs($user)->get(route('index')); // ルート名が違う場合はURLを直接指定

        $response->assertStatus(200);
        $response->assertSee('商品一覧');
        $response->assertSee('テスト商品');
        $response->assertSee('¥12,345');
        $response->assertSee('保有ポイント');
        $response->assertSee('5,000 pt');
        $response->assertSee('クーポンコード: TESTCOUPON');
    }
}
