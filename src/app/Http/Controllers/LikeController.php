<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Services\LikeService;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct(private LikeService $likeService) {}

    public function store(Item $item)
    {
        $this->likeService->toggle($item->id, Auth::id());

        return redirect()->back();
    }
}
