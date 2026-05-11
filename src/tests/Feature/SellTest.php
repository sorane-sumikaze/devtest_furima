<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_is_saved_with_required_fields(): void
    {
        Storage::fake('public');
        $user     = User::factory()->create();
        $category = Category::create(['name' => 'テストカテゴリ']);
        $image    = new UploadedFile(
            base_path('tests/Fixtures/test.jpg'),
            'product.jpg',
            'image/jpeg',
            null,
            true
        );

        $response = $this->actingAs($user)->post('/sell', [
            'image'       => $image,
            'item_name'   => '出品テスト商品',
            'brand_name'  => '出品テストブランド',
            'price'       => 5000,
            'description' => '出品商品の説明文',
            'condition'   => 1,
            'categories'  => [$category->id],
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('items', [
            'seller_id'   => $user->id,
            'item_name'   => '出品テスト商品',
            'brand_name'  => '出品テストブランド',
            'price'       => 5000,
            'description' => '出品商品の説明文',
            'condition'   => 1,
        ]);
    }
}
