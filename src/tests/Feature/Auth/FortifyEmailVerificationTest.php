<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Tests\TestCase;
use Carbon\Carbon;

class FortifyEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // テスト用にメール送信を無効化
        Notification::fake();
    }

    /** @test */
    public function sends_email_verification_link_after_registration()
    {
        if (! Features::enabled(Features::emailVerification())) {
            $this->markTestSkipped('Email verification is not enabled.');
        }

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // メール認証通知が送信されることを確認
        $user->sendEmailVerificationNotification();

        Notification::assertSentTo($user, \Illuminate\Auth\Notifications\VerifyEmail::class);
    }

    /** @test */
    public function verifies_user_email()
    {
        if (! Features::enabled(Features::emailVerification())) {
            $this->markTestSkipped('Email verification is not enabled.');
        }

        $user = User::factory()->create([
            'email_verified_at' => null,
            'is_approved' => true,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );


        $response = $this->actingAs($user)->get($verificationUrl);

        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
        $response->assertRedirect(config('fortify.home'));
    }

    /** @test */
    public function does_not_verify_email_with_invalid_link()
    {
        if (! Features::enabled(Features::emailVerification())) {
            $this->markTestSkipped('Email verification is not enabled.');
        }

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $validHash = sha1($user->getEmailForVerification());

        // 無効なリンクを作成 (期限切れ)
        $invalidVerificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->subMinutes(60), // 過去の時間を指定
            ['id' => $user->id, 'hash' => $validHash] // 正しい hash を使用
        );

        // 認証状態でアクセスを試みる
        $response = $this->actingAs($user)->get($invalidVerificationUrl);

        // 期待する結果：403 エラー
        $response->assertStatus(403);

        // email_verified_at が更新されていないことを確認
        $user->refresh();
        $this->assertNull($user->email_verified_at);
    }
}
