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

        $invalidVerificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->subMinutes(60),
            ['id' => $user->id, 'hash' => $validHash]
        );

        $response = $this->actingAs($user)->get($invalidVerificationUrl);

        $response->assertStatus(403);

        $user->refresh();
        $this->assertNull($user->email_verified_at);
    }
}
