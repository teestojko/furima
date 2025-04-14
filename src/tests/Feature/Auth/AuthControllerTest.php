<?php

namespace Tests\Feature\Auth;

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
        Order::factory()->count(2)->create();
        OrderStatus::factory()->count(2)->create();
        Product::factory()->count(2)->create();
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
