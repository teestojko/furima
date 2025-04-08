<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Review;
use App\Models\Tag;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_userIndex_returns_view_with_expected_data()
{
    $user = User::factory()->create(['points' => 100]);
    $this->actingAs($user);

    Cart::factory()->count(2)->create();
    $categories = Category::factory()->count(2)->create(); // ← これ使う！

    Order::factory()->count(2)->create();
    OrderStatus::factory()->count(2)->create();

    // category_id を指定してProductを作成
    Product::factory()->count(2)->create([
        'user_id' => $user->id,
        'category_id' => $categories->first()->id,
        'condition_id' => 1, // 必要なら調整
        'delivery_method_id' => 1, // 必要なら調整
    ]);

    Review::factory()->count(2)->create();
    Tag::factory()->count(2)->create();
    Coupon::factory()->count(2)->state(['is_active' => true])->create();

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertViewIs('index');
    $response->assertViewHasAll([
        'user_name',
        'user',
        'carts',
        'categories',
        'orders',
        'order_status',
        'products',
        'reviews',
        'tags',
        'points',
        'coupons',
    ]);

    $this->assertEquals($user->name, $response->viewData('user_name'));
    $this->assertEquals(100, $response->viewData('points'));
}

}
