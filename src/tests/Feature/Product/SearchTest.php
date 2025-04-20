<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ゲストでも検索ページにアクセスできる()
    {
        $response = $this->get(route('products-filter'));

        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    /** @test */
    public function 商品名で部分一致検索できる()
    {
        $product1 = Product::factory()->create(['name' => 'Laravel Book']);
        $product2 = Product::factory()->create(['name' => 'PHP Guide']);

        $response = $this->get(route('products-filter', ['product_name' => 'Laravel']));

        $response->assertViewHas('products', function ($products) use ($product1, $product2) {
            return $products->contains($product1) && !$products->contains($product2);
        });
    }

    /** @test */
    public function カテゴリで検索できる()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $product1 = Product::factory()->create(['category_id' => $category1->id]);
        $product2 = Product::factory()->create(['category_id' => $category2->id]);

        $response = $this->get(route('products-filter', ['category_id' => $category1->id]));

        $response->assertViewHas('products', function ($products) use ($product1, $product2) {
            return $products->contains($product1) && !$products->contains($product2);
        });
    }

    /** @test */
    public function 価格帯で検索できる()
    {
        $product1 = Product::factory()->create(['price' => 1000]);
        $product2 = Product::factory()->create(['price' => 3000]);

        $response = $this->get(route('products-filter', [
            'min_price' => 500,
            'max_price' => 2000,
        ]));

        $response->assertViewHas('products', function ($products) use ($product1, $product2) {
            return $products->contains($product1) && !$products->contains($product2);
        });
    }

    /** @test */
    public function 価格順に並び替えできる()
    {
        Product::factory()->create(['price' => 1000]);
        Product::factory()->create(['price' => 2000]);

        $response = $this->get(route('products-filter', ['price_order' => 'desc']));

        $products = $response->viewData('products');

        $this->assertTrue($products->first()->price >= $products->last()->price);
    }

    /** @test */
    public function 人気順に並び替えできる()
    {
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        // product1 の注文を3件作成
        for ($i = 0; $i < 3; $i++) {
            $order = Order::factory()->create();
            OrderItem::factory()->create([
                'order_id' => $order->id,
                'product_id' => $product1->id,
            ]);
        }

        // product2 の注文を1件作成
        $order = Order::factory()->create();
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product2->id,
        ]);

        $response = $this->get(route('products-filter', ['popularity' => 'desc']));

        $response->assertOk();
        $products = $response->viewData('products');

        $this->assertEquals($product1->id, $products->first()->id);
    }
}
