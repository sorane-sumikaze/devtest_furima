<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Services\StripeCheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Checkout\Session as StripeSession;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    private function userWithAddress(): User
    {
        return User::factory()->create([
            'post_code' => '123-4567',
            'address'   => '東京都渋谷区1-1-1',
        ]);
    }

    private function mockStripe(User $user, Item $item): void
    {
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
                'ship_post_code' => $user->post_code,
                'ship_address'   => $user->address,
                'ship_building'  => '',
            ],
        ]);

        $this->mock(StripeCheckoutService::class, function ($mock) use ($fakeCreate, $fakeRetrieve) {
            $mock->shouldReceive('createSession')->andReturn($fakeCreate);
            $mock->shouldReceive('retrieveSession')->andReturn($fakeRetrieve);
        });
    }

    public function test_purchase_completes_successfully(): void
    {
        $user = $this->userWithAddress();
        $item = Item::factory()->create(['item_name' => '購入テスト商品']);

        $this->mockStripe($user, $item);

        $this->actingAs($user)->post('/purchase/' . $item->id, ['payment_method' => 1]);
        $response = $this->actingAs($user)->get('/purchase/complete?session_id=cs_test_123');

        $response->assertRedirect('/');
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
        $this->assertTrue($item->fresh()->sold);
    }

    public function test_purchased_item_shows_sold_on_list(): void
    {
        $user = $this->userWithAddress();
        $item = Item::factory()->create();

        $this->mockStripe($user, $item);

        $this->actingAs($user)->post('/purchase/' . $item->id, ['payment_method' => 1]);
        $this->actingAs($user)->get('/purchase/complete?session_id=cs_test_123');

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    public function test_purchased_item_appears_in_profile_buy_list(): void
    {
        $user = $this->userWithAddress();
        $item = Item::factory()->create(['item_name' => 'プロフィール購入商品テスト']);

        $this->mockStripe($user, $item);

        $this->actingAs($user)->post('/purchase/' . $item->id, ['payment_method' => 1]);
        $this->actingAs($user)->get('/purchase/complete?session_id=cs_test_123');

        $response = $this->actingAs($user)->get('/mypage?tab=buy');

        $response->assertSee('プロフィール購入商品テスト');
    }
}
