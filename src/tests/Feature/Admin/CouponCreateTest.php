<?php

namespace tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CouponCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function クーポン作成ページが表示される()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get(route('admin.coupons-create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.coupon_create');
    }

    /** @test */
    public function 必須項目がない場合バリデーションエラー()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->post(route('admin.coupons-store'), [
            'code' => '',
            'discount' => '',
            'discount_type' => '',
            'valid_from' => '',
            'valid_until' => '',
        ]);

        $response->assertSessionHasErrors(['code', 'discount', 'discount_type', 'valid_from', 'valid_until']);
    }

    /** @test */
    public function クーポンが正常に作成される()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->post(route('admin.coupons-store'), [
            'code' => 'DISCOUNT20',
            'discount' => 20,
            'discount_type' => 'percentage',
            'valid_from' => now(),
            'valid_until' => now()->addDays(30),
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('coupons', [
            'code' => 'DISCOUNT20',
            'discount' => 20,
            'discount_type' => 'percentage',
        ]);
    }
}
