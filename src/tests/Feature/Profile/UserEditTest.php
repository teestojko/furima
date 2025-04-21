<?php

namespace Tests\Feature\Profile;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログインユーザーはプロフィール編集画面にアクセスできる()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('user-edit'));

        $response->assertStatus(200)
                 ->assertViewIs('profile.user_edit')
                 ->assertSee($user->name);
    }

    /** @test */
    public function 名前とメールアドレスを更新できる()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('user-update'), [
            'name' => '新しい名前',
            'email' => 'new@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '新しい名前',
            'email' => 'new@example.com',
        ]);
    }

    /** @test */
    public function 正しいパスワードを入力すればパスワードを変更できる()
    {
        $user = User::factory()->create([
            'password' => bcrypt('current-pass'),
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        Storage::fake('public');

        $this->actingAs($user)->post(route('user-update'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'current_password' => 'current-pass',
            'new_password' => 'new-secure-pass',
            'new_password_confirmation' => 'new-secure-pass',
            'profile_image' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

    $this->assertTrue(Hash::check('new-secure-pass', $user->fresh()->password));
}


    /** @test */
    public function 間違った現在のパスワードを入力するとエラーが返る()
    {
        $user = User::factory()->create([
            'password' => Hash::make('correct-pass'),
        ]);

        $response = $this->actingAs($user)->from(route('user-edit'))->post(route('user-update'), [
            'name' => $user->name,
            'email' => $user->email,
            'current_password' => 'wrong-pass',
            'new_password' => 'new-password',
        ]);

        $response->assertRedirect(route('user-edit'));
        $response->assertSessionHasErrors(['current_password']);
    }

    /** @test */
    public function プロフィール画像をアップロードできる()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)->post(route('user-update'), [
            'name' => $user->name,
            'email' => $user->email,
            'profile_image' => $file,
        ]);

        // ここで保存されたファイル名を取得
        $expectedPath = 'profile_images/' . $file->hashName();

        // このパスでファイルが存在するか確認
        Storage::disk('public')->assertExists($expectedPath);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_image' => $expectedPath,
        ]);


        $response->assertSessionHas('success', 'プロフィール情報を更新しました');
    }
}
