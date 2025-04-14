<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // 管理者でログイン（admin guard 指定）
        $this->admin = Admin::factory()->create();
        $this->actingAs($this->admin, 'admin');
    }

    /** @test */
    public function カテゴリー一覧ページが表示される()
    {
        Category::factory()->count(3)->create();

        $response = $this->get(route('admin.categories.index'));

        $response->assertStatus(200)
                 ->assertViewIs('admin.category_index');
    }

    /** @test */
    public function カテゴリー作成ページが表示される()
    {
        $response = $this->get(route('admin.categories.create'));

        $response->assertStatus(200)
                 ->assertViewIs('admin.category_create');
    }

    /** @test */
    public function カテゴリーを新規作成できる()
    {
        $data = ['name' => 'テストカテゴリー'];

        $response = $this->post(route('admin.categories.store'), $data);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', $data);
    }

    /** @test */
    public function カテゴリーを編集できる()
    {
        $category = Category::factory()->create(['name' => '旧カテゴリー']);

        $response = $this->put(route('admin.categories.update', $category), [
            'name' => '新カテゴリー名',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => '新カテゴリー名']);
    }

    /** @test */
    public function カテゴリーを削除できる()
    {
        $category = Category::factory()->create(['name' => '削除対象']);

        $response = $this->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['name' => '削除対象']);
    }
}
