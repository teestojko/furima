<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログインフォームが表示されることを確認するテスト
     *
     * @return void
     */
    public function test_login_form_is_displayed()
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.login');
    }

    /**
     * 無効な資格情報でログインを試みるテスト
     *
     * @return void
     */
    public function test_invalid_credentials()
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302); // リダイレクト
        $response->assertSessionHasErrors(['email' => 'メールアドレスまたはパスワードが一致しません.']);
    }

    /**
     * 有効な資格情報でログインするテスト
     *
     * @return void
     */
    public function test_valid_credentials()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => $admin->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }
}
