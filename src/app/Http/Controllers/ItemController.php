<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function __construct(private ItemService $itemService) {}

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommended');

        if ($tab === 'mylist') {
            $items = $this->itemService->getMyListItems();
        } else {
            $tab = 'recommended';
            $items = $this->itemService->getRecommendedItems();
        }

        return view('index', compact('items', 'tab'));
    }

    public function search(Request $request)
    {
        $keyword = $request->query('keyword', '');
        $tab     = $request->query('tab', 'recommended');

        if ($tab !== 'mylist') {
            $tab = 'recommended';
        }

        $items = $this->itemService->search($keyword, $tab);

        return view('index', compact('items', 'tab', 'keyword'));
    }

    public function show(Item $item)
    {
        $item = $this->itemService->getItemDetail($item);
        $isLiked = $item->likes->contains('user_id', Auth::id());

        return view('items.show', compact('item', 'isLiked'));
    }
}
