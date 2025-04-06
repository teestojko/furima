<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Report;
use App\Models\Product;
use App\Models\User;

class ReportFactory extends Factory
{
    protected $model = Report::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reported_product_id' => Product::inRandomOrder()->first()->id, // ランダムに商品を選択
            'reported_user_id' => User::inRandomOrder()->first()->id, // ランダムにユーザーを選択
            'reporter_user_id' => User::inRandomOrder()->first()->id, // 通報者もランダムにユーザーを選択
            'reason' => $this->faker->sentence, // 通報理由（ランダムな文）
            'comment' => $this->faker->paragraph, // 詳細コメント（ランダムな段落）
        ];
    }
}
