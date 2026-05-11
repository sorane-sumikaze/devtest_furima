<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Services\StripeCheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Checkout\Session as StripeSession;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_address_is_reflected_on_purchase_screen(): void
    {
        $user = User::factory()->create([
            'post_code' => '000-0000',
            'address'   => '旧住所',
        ]);
        $item = Item::factory()->create();

        $this->actingAs($user)->put('/purchase/address/' . $item->id, [
            'post_code' => '987-6543',
            'address'   => '新しい住所東京都',
        ]);

        $response = $this->actingAs($user)->get('/purchase/' . $item->id);

        $response->assertSee('987-6543');
        $response->assertSee('新しい住所東京都');
    }

    public function test_purchased_item_is_linked_to_ship_address(): void
    {
        $user = User::factory()->create([
            'post_code' => '123-4567',
            'address'   => '配送先住所テスト',
        ]);
        $item = Item::factory()->create();

        $fakeCreate = StripeSession::constructFrom([
            'id'  => 'cs_test_123',
            'url' => 'https://checkout.stripe.com/test',
        ]);

        $fakeRetrieve = StripeSession::constructFrom([
            'id'     => 'cs_test_123',
            'status' => 'complete',
            'metadata' => [
                'item_id'        => (string) $item->id,
                'user_id'        => (string) $user->id,
                'payment_method' => '1',
                'ship_post_code' => '123-4567',
                'ship_address'   => '配送先住所テスト',
                'ship_building'  => '',
            ],
        ]);

        $this->mock(StripeCheckoutService::class, function ($mock) use ($fakeCreate, $fakeRetrieve) {
            $mock->shouldReceive('createSession')->andReturn($fakeCreate);
            $mock->shouldReceive('retrieveSession')->andReturn($fakeRetrieve);
        });

        $this->actingAs($user)->post('/purchase/' . $item->id, ['payment_method' => 1]);
        $this->actingAs($user)->get('/purchase/complete?session_id=cs_test_123');

        $this->assertDatabaseHas('purchases', [
            'item_id'        => $item->id,
            'ship_post_code' => '123-4567',
            'ship_address'   => '配送先住所テスト',
        ]);
    }
}
