<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewRequest;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
        public function review(Product $product)
    {
        return view('Review.review', compact('product'));
    }

    public function store(ReviewRequest $request, Product $product)
    {
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();
            if ($existingReview) {
                return redirect()->back()->withErrors(['custom_error' => '既にこの店舗にレビューを投稿しています。']);
            }
        $review = new Review();
        $review->user_id = Auth::id();
        $review->product_id = $product->id;
        $review->comment = $request->comment;
        $review->stars = $request->stars;
        // レビューの平均を更新
        $averageStars = $product->reviews()->avg('stars');
        $product->average_stars = $averageStars;

        $review->save();
        return back()
        ->with('success', 'レビューを投稿しました');
    }

    public function index(Product $product)
    {
        $reviews = Review::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->get();
        return view('Review.index', compact('reviews', 'product'));
    }

    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            return response()->json(['error' => 'この操作を実行する権限がありません。'], 403);
        }
        $review->delete();
        return back()->with('success', 'レビューを削除しました');
    }
}
