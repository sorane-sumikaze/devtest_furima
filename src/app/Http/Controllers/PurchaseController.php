<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\User;
use App\Services\PurchaseService;
use App\Services\StripeCheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function __construct(
        private PurchaseService $purchaseService,
        private StripeCheckoutService $stripeCheckoutService
    ) {}

    public function show(Item $item)
    {
        $user = Auth::user();

        if (empty($user->post_code) || empty($user->address)) {
            return redirect('/mypage/profile')->withErrors(['error' => '購入前に住所を設定してください']);
        }

        return view('purchase.index', compact('item', 'user'));
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        if ($item->seller_id === Auth::id()) {
            return redirect()->back()->withErrors(['error' => '自分の出品商品は購入できません']);
        }

        if ($item->sold) {
            return redirect()->back()->withErrors(['error' => 'この商品はすでに購入されています']);
        }

        $user = Auth::user();
        $paymentMethod = (int) $request->payment_method;
        $paymentTypes  = $paymentMethod === 1 ? ['card'] : ['konbini'];

        $session = $this->stripeCheckoutService->createSession([
            'payment_method_types' => $paymentTypes,
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'jpy',
                    'product_data' => ['name' => $item->item_name],
                    'unit_amount'  => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'item_id'        => $item->id,
                'user_id'        => $user->id,
                'payment_method' => $paymentMethod,
                'ship_post_code' => $user->post_code,
                'ship_address'   => $user->address,
                'ship_building'  => $user->building ?? '',
            ],
            'success_url' => route('purchase.complete') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('purchase.show', $item->id),
        ]);

        return redirect($session->url);
    }

    public function complete(Request $request)
    {
        $session = $this->stripeCheckoutService->retrieveSession($request->session_id);

        if ($session->status !== 'complete') {
            return redirect('/')->withErrors(['error' => '決済が完了していません']);
        }

        $meta = $session->metadata;
        $item = Item::findOrFail($meta->item_id);
        $user = User::findOrFail($meta->user_id);

        try {
            $this->purchaseService->purchase($item, $user, (int) $meta->payment_method, [
                'ship_post_code' => $meta->ship_post_code,
                'ship_address'   => $meta->ship_address,
                'ship_building'  => $meta->ship_building ?: null,
            ]);
        } catch (\RuntimeException $e) {
            return redirect('/')->withErrors(['error' => $e->getMessage()]);
        }

        return redirect('/');
    }
}
