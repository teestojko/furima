<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function reviewページが表示される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get(route('reviews-review', $product));

        $response->assertStatus(200);
        $response->assertViewIs('review.review');
        $response->assertViewHas('product', $product);
    }

    /** @test */
    public function レビューを投稿できる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'stars' => 5,
            'comment' => '素晴らしい商品でした！'
        ];

        $response = $this->actingAs($user)->post(route('reviews-store', $product), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'stars' => 5,
            'comment' => '素晴らしい商品でした！'
        ]);
    }

    /** @test */
    public function 同じ商品には複数レビューできない()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // すでにレビュー投稿済み
        Review::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        $response = $this->actingAs($user)->post(route('reviews-store', $product), [
            'stars' => 4,
            'comment' => '2回目のレビュー'
        ]);

        $response->assertSessionHasErrors('custom_error');
    }

    /** @test */
    public function 自分のレビュー一覧が表示される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->get(route('reviews-index', $product));

        $response->assertStatus(200);
        $response->assertViewHas('reviews', function ($reviews) use ($review) {
            return $reviews->contains($review);
        });
    }

    /** @test */
    public function 自分のレビューを削除できる()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(route('reviews-destroy', $review));

        $response->assertRedirect();
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    /** @test */
    public function 他人のレビューは削除できない()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($user)->delete(route('reviews-destroy', $review));

        $response->assertStatus(403);
        $this->assertDatabaseHas('reviews', ['id' => $review->id]);
    }
}
