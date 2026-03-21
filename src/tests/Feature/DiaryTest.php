<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Diary;

class DiaryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    // 一覧画面が表示できるか
    public function test_001()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // 日記投稿が可能か
    public function test_002()
    {
        $response = $this->post('/diaries', [
            'body' => 'テスト日記'
        ]);

        $this->assertDatabaseHas('diaries', [
            'body' => 'テスト日記'
        ]);
    }

    // 20文字のバリデーションチェック
    public function test_003()
    {
        $response = $this->post('/diaries', [
            'body' => str_repeat('あ', 21)
        ]);

        $response->assertSessionHasErrors('body');
    }

    // 削除が可能か
    public function test_004()
    {
        $diary = Diary::factory()->create();

        $response = $this->delete('/diaries/' . $diary->id);

        $this->assertDatabaseMissing('diaries', [
            'id' => $diary->id
        ]);
    }
}