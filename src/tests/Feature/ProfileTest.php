<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_shows_required_info(): void
    {
        $user = User::factory()->create(['user_name' => 'プロフィールユーザー']);
        $item = Item::factory()->create([
            'seller_id' => $user->id,
            'item_name' => 'ユーザー出品商品テスト',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('プロフィールユーザー');
        $response->assertSee('ユーザー出品商品テスト');
    }

    public function test_profile_edit_shows_existing_values(): void
    {
        $user = User::factory()->create([
            'user_name' => '既存ユーザー名',
            'post_code' => '111-2222',
            'address'   => '既存の住所',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('既存ユーザー名');
        $response->assertSee('111-2222');
        $response->assertSee('既存の住所');
    }
}
