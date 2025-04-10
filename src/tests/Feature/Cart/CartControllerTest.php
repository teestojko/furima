<?php

namespace tests\Feature\Cart;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * カートに商品を追加するテスト
     *
     * @return void
     */
    public function test_add_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // ログイン
        $this->actingAs($user);

        // 商品をカートに追加
        $response = $this->post(route('cart-add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // カートに商品が追加されたことを確認
        $response->assertRedirect();
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    /**
     * カートから商品を削除するテスト
     *
     * @return void
     */
    public function test_remove_from_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // ログイン
        $this->actingAs($user);

        // 商品をカートに追加
        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // 商品をカートから削除
        $response = $this->delete(route('cart-remove', ['id' => $cart->id]));

        // 商品がカートから削除されたことを確認
        $response->assertRedirect();
        $this->assertDatabaseMissing('carts', [
            'id' => $cart->id,
        ]);
    }

    /**
     * カートの商品一覧が表示されるテスト
     *
     * @return void
     */
    public function test_view_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // ログイン
        $this->actingAs($user);

        // 商品をカートに追加
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // カートページにアクセス
        $response = $this->get(route('cart-view'));

        // カートの内容が表示されていることを確認
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /**
     * 支払い準備ができることを確認するテスト
     *
     * @return void
     */
    public function test_prepare_payment()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // ログイン
        $this->actingAs($user);

        // 商品をカートに追加
        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // 支払い準備ページにリクエスト
        $response = $this->post(route('cart-purchase'), [
            'selected_items' => [$cart->id],
        ]);

        // リダイレクトされることを確認
        $response->assertRedirect(route('payment-show'));
        $response->assertSessionHas('selected_items');
        $response->assertSessionHas('total_amount');
    }

    /**
     * 商品が選択されていない場合、エラーメッセージが表示されるテスト
     *
     * @return void
     */
    public function test_prepare_payment_no_selected_items()
    {
        $user = User::factory()->create();

        // ログイン
        $this->actingAs($user);

        // 支払い準備ページにリクエスト（商品を選択しない）
        $response = $this->post(route('cart-purchase'), [
            'selected_items' => [],
        ]);

        // エラーメッセージが表示されることを確認
        $response->assertRedirect();
        $response->assertSessionHas('error', '商品が選択されていません');
    }
}
