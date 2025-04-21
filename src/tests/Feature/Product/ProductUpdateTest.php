<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Image;

class ProductUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 出品者は編集画面にアクセスできる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('products-edit', $product));
        $response->assertOk();
        $response->assertViewIs('product.edit');
        $response->assertViewHas(['product', 'categories', 'conditions']);
    }

    /** @test */
    public function 出品者以外は編集画面にアクセスできない()
    {
        $product = Product::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->get(route('products-edit', $product));
        $response->assertForbidden();
    }

    /** @test */
    public function 出品者は商品情報を更新できる()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        $product = Product::factory()->for($user)->create([
            'name' => '旧商品名',
        ]);

        // 既存画像も追加
        $existingImage = Image::factory()->create([
            'product_id' => $product->id,
            'path' => 'storage/images/old_image.jpg',
        ]);

        Storage::put('public/images/old_image.jpg', 'dummy content');

        $newImage = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($user)->put(route('products-update', $product), [
            'name' => '新商品名',
            'detail' => '新しい詳細',
            'price' => 1000,
            'stock' => 5,
            'category_id' => $category->id,
            'condition_id' => $condition->id,
            'images' => [$newImage],
        ]);

        $response->assertRedirect(route('products-show', $product));
        $response->assertSessionHas('success', '商品情報が更新されました');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => '新商品名',
        ]);

        $this->assertDatabaseMissing('images', [
            'id' => $existingImage->id,
        ]);

        $this->assertDatabaseCount('images', 1);

        Storage::disk('public')->assertMissing('images/old_image.jpg');
        Storage::disk('public')->assertExists('images/' . basename(Image::first()->path));
    }

    public function test_出品者以外は商品を更新できない()
    {
        $product = Product::factory()->create();
        $otherUser = User::factory()->create();

        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        $response = $this->actingAs($otherUser)->put(route('products-update', $product), [
            'name' => '変更しちゃうよ',
            'detail' => 'ダミーの詳細です',
            'price' => 1234,
            'stock' => 10,
            'category_id' => $category->id,
            'condition_id' => $condition->id,
        ]);

        $response->assertForbidden(); // ポリシーが効いてるかチェック
    }
}
