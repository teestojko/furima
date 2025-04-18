<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_product_with_images()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        $image1 = UploadedFile::fake()->image('photo1.jpg');
        $image2 = UploadedFile::fake()->image('photo2.jpg');

        $response = $this->actingAs($user)->post(route('products-store'), [
            'name' => 'テスト商品',
            'detail' => '詳細説明',
            'price' => 1000,
            'stock' => 5,
            'category_id' => $category->id,
            'condition_id' => $condition->id,
            'images' => [$image1, $image2],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', '商品が出品されました');

        $this->assertDatabaseHas('products', [
            'name' => 'テスト商品',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseCount('images', 2);

        // ✅ ここを修正：事前に作った画像のハッシュ名を使う
        Storage::disk('public')->assertExists('images/' . $image1->hashName());
        Storage::disk('public')->assertExists('images/' . $image2->hashName());
    }


    public function test_store_product_without_images()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        $response = $this->actingAs($user)->post(route('products-store'), [
            'name' => '商品名',
            'detail' => '説明',
            'price' => 500,
            'stock' => 10,
            'category_id' => $category->id,
            'condition_id' => $condition->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', '画像が選択されていません');

        $this->assertDatabaseHas('products', [
            'name' => '商品名',
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseCount('images', 0);
    }

    
    public function test_guest_cannot_store_product()
    {
        $response = $this->post(route('products-store'), []);
        $response->assertRedirect(route('login'));
    }
}
