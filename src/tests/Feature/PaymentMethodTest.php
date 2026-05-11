<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_method_is_reflected_on_purchase_page(): void
    {
        $user = User::factory()->create([
            'post_code' => '123-4567',
            'address'   => '東京都渋谷区1-1-1',
        ]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get('/purchase/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('クレジットカード');
        $response->assertSee('コンビニ払い');
        $response->assertSee('—');
    }
}
