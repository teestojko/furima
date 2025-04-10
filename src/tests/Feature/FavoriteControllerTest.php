<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_favorites_displays_user_favorites()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->favoriteProducts()->attach($product);

        $response = $this->actingAs($user)->get('/my_page');

        $response->assertStatus(200);
        $response->assertViewHas('favoriteProducts', function ($favorites) use ($product) {
            return $favorites->contains($product);
        });
    }

    public function test_toggle_favorite_adds_product_if_not_favorited()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post("/favorites/{$product->id}/toggle");

        $response->assertJson(['status' => 'added']);
        $this->assertTrue($user->fresh()->favoriteProducts->contains($product));
    }

    public function test_toggle_favorite_removes_product_if_already_favorited()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->favoriteProducts()->attach($product);

        $response = $this->actingAs($user)->post("/favorites/{$product->id}/toggle");

        $response->assertJson(['status' => 'removed']);
        $this->assertFalse($user->fresh()->favoriteProducts->contains($product));
    }
}
