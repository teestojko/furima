<?php

namespace Tests\Feature\Report;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Report;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportNotification;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create画面が正常に表示される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $seller = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $response = $this->get(route('report-create', ['reported_product_id' => $product->id]));

        $response->assertStatus(200);
        $response->assertViewIs('report.create');
        $response->assertViewHasAll([
            'reportedProduct',
            'reportedUser',
        ]);
    }

    /** @test */
    public function test_store_で通報が保存され管理者にメールが送信される()
{
    Mail::fake();

    $admin = Admin::factory()->create([
        'email' => 'admin@example.com',
    ]);

    $reporter = User::factory()->create();
    $reportedUser = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $reportedUser->id]);

    $this->actingAs($reporter)->post(route('report-store'), [
        'reported_product_id' => $product->id,
        'reported_user_id' => $reportedUser->id,
        'reason' => 'スパムの可能性',
        'comment' => '怪しい出品です',
    ]);

    Mail::assertSent(ReportNotification::class, function ($mail) use ($admin) {
        return collect($mail->to)->pluck('address')->contains($admin->email);
    });
}

}
